<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderItemController extends Controller
{
    public function itemsList()
    {
        $items = Item::all();
        return view('pages.items.index', compact('items'));
    }

    public function itemOrderCard(Item $item)
    {
        $popularItems = Item::orderBy('sold', 'desc')->take(5)->get();
        return view('pages.items.item_order', compact('item', 'popularItems'));
    }

    public function itemAddToCart(Request $request, Item $item)
    {
        $cartQuantity = $request->input('cart_quantity', 1);
        $cartQuantity = min($cartQuantity, $item->stocks);

        if ($item->item_status === 'in_stock' && $cartQuantity > 0) {
            $cart = Cart::where('item_id', $item->item_id)
                        ->where('user_id', auth()->user()->user_id)
                        ->first();

            if ($cart) {
                $cart->increment('quantity', $cartQuantity);
                $cart->sub_total = $cart->quantity * $item->price;
                $cart->save();
            } else {
                Cart::create([
                    'item_id'   => $item->item_id,
                    'user_id'   => auth()->user()->user_id,
                    'quantity'  => $cartQuantity,
                    'sub_total' => $item->price * $cartQuantity,
                ]);
            }
            return redirect()->route('items')->with('success', 'Item added to cart successfully.');
        }

        return redirect()->back()->with('error', 'Item is out of stock or invalid quantity.');
    }

    public function itemsOrderCheckOut(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        $quantities = $request->input('quantity', []);
    
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Please select at least one item to proceed.');
        }
    
        $carts = Cart::whereIn('cart_id', $selectedItems)
                      ->where('user_id', Auth::id())
                      ->with('item')
                      ->get();
    
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'No valid items found in the cart.');
        }
    
        $totalAmount = 0;
        $shipmentItems = [];
    
        foreach ($carts as $cart) {
            $item = $cart->item;
            $cartId = $cart->cart_id;
    
            if (isset($quantities[$cartId])) {
                $requestedQty = (int) $quantities[$cartId];
    
                if ($requestedQty > $item->stocks) {
                    return redirect()->back()->with('error', 'Insufficient stock for item: ' . $item->item_name);
                }
    
                $cart->quantity = $requestedQty;
                $cart->sub_total = $requestedQty * $item->price;
                $cart->save();
    
                $shipmentItems[] = [
                    'item_id'   => $item->item_id,
                    'quantity'  => $requestedQty,
                    'sub_total' => $cart->sub_total,
                ];
    
                $totalAmount += $cart->sub_total;
            }
        }
    
        session(['itemsCheckout' => $selectedItems]);
        return redirect()->route('items.summary');
    }
    
    public function itemOrderSummary()
    {
        $selectedItems = session('itemsCheckout', []);
        $carts = Cart::whereIn('cart_id', $selectedItems)
                     ->where('user_id', Auth::id())
                     ->with('item')
                     ->get();
    
        $totalAmount = $carts->sum('sub_total');
        $customer = Auth::user();
    
        return view('pages.items.order_summary', compact('selectedItems', 'carts', 'totalAmount', 'customer'));
    }

    public function itemShipOrder(Request $request)
    {
        $request->validate([
            'shipment_method'   => 'required|in:courier,on_site_pickup',
            'payment_method'    => 'required|in:gcash,cash_on_delivery',
        ]);

        $selectedItems = session('itemsCheckout', []);
        $user = Auth::user();

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'No items selected for shipment.');
        }

        $carts = Cart::whereIn('cart_id', $selectedItems)
                    ->where('user_id', $user->user_id)
                    ->with('item')
                    ->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        if ($request->payment_method === 'gcash') {
            return $this->initiateGcashPayment($carts);
        }

        DB::beginTransaction();

        try {
            foreach ($carts as $cart) {
                $item = $cart->item;

                if (!$item) {
                    throw new \Exception("Item not found for cart ID {$cart->cart_id}");
                }

                if ($item->stocks < $cart->quantity) {
                    throw new \Exception("Not enough stock for item: {$item->item_name}");
                }

                $item->decrement('stocks', $cart->quantity);
                $item->increment('sold', $cart->quantity);

                Inventory::create([
                    'inventory_type'    => 'product',
                    'inventoryable_id'  => $item->item_id,
                    'amount'            => -$cart->quantity,
                ]);

                $shipment = Shipment::create([
                    'cart_id'           => $cart->cart_id,
                    'total_amount'      => $cart->sub_total,
                    'item_status'       => 'pending',
                    'shipment_date'     => now(),
                    'shipment_method'   => $request->shipment_method,
                    'payment_method'    => $request->payment_method,
                    'payment_status'    => 'pending',
                    'payment_reference' => null,
                ]);

                $cart->shipment_id = $shipment->shipment_id;
                $cart->save();

                Product::create([
                    'user_id'         => $user->user_id,
                    'shipment_id'     => $shipment->shipment_id,
                    'amount'          => $shipment->total_amount,
                    'tracking_number' => 'TRK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                ]);
            }

            DB::commit();
            session()->forget('itemsCheckout');
            return redirect()->route('items')->with('success', 'Order placed and shipment created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function initiateGcashPayment($carts)
    {
        $user = Auth::user();

        $lineItems = $carts->map(function ($cart) {
            return [
                'amount'    => (int) round($cart->item->price * 100),
                'currency'  => 'PHP',
                'name'      => $cart->item->item_name,
                'quantity'  => $cart->quantity,
            ];
        })->toArray();

        $redirectUrl = route('gcash.success');
        $cancelUrl = route('gcash.cancel');

        try {
            session([
                'pending_payment_data'  => [
                    'user_id'           => $user->user_id,
                    'selected_items'    => $carts->pluck('cart_id')->toArray(),
                    'shipment_method'   => request('shipment_method'),
                    'payment_method'    => 'gcash',
                ]
            ]);

            $response = Http::withHeaders([
                'Authorization'     => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
                'Content-Type'      => 'application/json',
            ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes'    => [
                        'billing'   => [
                            'name'  => $user->first_name . ' ' . $user->last_name,
                            'email' => $user->email,
                            'phone' => $user->contact_number
                        ],
                        'line_items'            => $lineItems,
                        'payment_method_types'  => ['gcash'],
                        'success_url'           => $redirectUrl,
                        'cancel_url'            => $cancelUrl,
                        'description'           => 'Order payment via GCash',
                    ]
                ]
            ]);

            $paymentData = $response->json();

            if (isset($paymentData['data']['attributes']['checkout_url'])) {
                return redirect($paymentData['data']['attributes']['checkout_url']);
            } else {
                return redirect()->back()->with('error', 'Failed to initiate GCash payment.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to initiate GCash payment: ' . $e->getMessage());
        }
    }

    public function gcashSuccess()
    {
        $user = Auth::user();
        $data = session('pending_payment_data');
    
        if (!$data || $user->user_id !== $data['user_id']) {
            return redirect()->route('items')->with('error', 'Invalid or expired payment session.');
        }
    
        $carts = Cart::whereIn('cart_id', $data['selected_items'])
                    ->where('user_id', $user->user_id)
                    ->with('item')
                    ->get();
    
        DB::beginTransaction();
    
        try {
            foreach ($carts as $cart) {
                $item = $cart->item;
    
                if (!$item) {
                    throw new \Exception("Item not found for cart ID {$cart->cart_id}");
                }
    
                if ($item->stocks < $cart->quantity) {
                    throw new \Exception("Not enough stock for item: {$item->item_name}");
                }
    
                $item->decrement('stocks', $cart->quantity);
                $item->increment('sold', $cart->quantity);

                Inventory::create([
                    'inventory_type'    => 'product',
                    'inventoryable_id'  => $item->item_id,
                    'amount'            => -$cart->quantity,
                ]);

                $shipment = Shipment::create([
                    'cart_id'           => $cart->cart_id,
                    'total_amount'      => $cart->sub_total,
                    'item_status'       => 'pending',
                    'shipment_date'     => now(),
                    'shipment_method'   => $data['shipment_method'],
                    'payment_method'    => 'gcash',
                    'payment_status'    => 'paid',
                    'payment_reference' => 'GCASH-' . strtoupper(Str::random(10))
                ]);
    
                $cart->shipment_id = $shipment->shipment_id;
                $cart->save();
                
                Product::create([
                    'user_id'         => $user->user_id,
                    'shipment_id'     => $shipment->shipment_id,
                    'amount'          => $shipment->total_amount,
                    'tracking_number' => 'TRK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6))
                ]);
            }
    
            DB::commit();
            session()->forget(['itemsCheckout', 'pending_payment_data']);
    
            return redirect()->route('items')->with('success', 'GCash payment successful. Shipment created.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to finalize GCash order', ['error' => $e->getMessage()]);
            return redirect()->route('items')->with('error', 'Something went wrong after GCash payment.');
        }
    }
}
