<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
                    'item_id'      => $item->item_id,
                    'user_id'      => auth()->user()->user_id,
                    'quantity'     => $cartQuantity,
                    'sub_total'    => $item->price * $cartQuantity
                ]);
            }
            $item->decrement('stocks', $cartQuantity);

            return redirect()->route('items')->with('success', 'Item added to cart successfully');
        }
        return redirect()->back()->with('error', 'Item is out of stock or invalid quantity');
    }

    public function itemsOrderCheckOut(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        $quantities = $request->input('quantity', []);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'No items selected for checkout.');
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

            if (isset($quantities[$cart->cart_id])) {
                $cart->quantity = $quantities[$cart->cart_id];
                $cart->sub_total = $cart->quantity * $item->price;
                $cart->save();

                $item->decrement('stocks', $cart->quantity);

                $shipmentItems[] = [
                    'item_id' => $item->item_id,
                    'quantity' => $cart->quantity,
                    'sub_total' => $cart->sub_total
                ];
            }
            $totalAmount += $cart->sub_total;
        }

        // Store selected items in the session for the next request
        session(['itemsCheckout' => $selectedItems]);

        // Log for debugging
        Log::info('Selected items for checkout: ', $selectedItems);
        
        return redirect()->route('items.summary');
    }

    public function itemOrderSummary()
    {
        $selectedItems = session('itemsCheckout', []);
        Log::info('Selected items in summary: ', $selectedItems);

        $carts = Cart::whereIn('cart_id', $selectedItems)
                     ->where('user_id', Auth::id())
                     ->with('item')
                     ->get();
        $totalAmount = $carts->sum('sub_total');
        $customer = Auth::user();

        return view('pages.items.item_order_summary', compact('selectedItems', 'carts', 'totalAmount', 'customer'));
    }
}
