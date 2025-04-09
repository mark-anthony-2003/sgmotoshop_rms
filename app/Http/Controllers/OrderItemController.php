<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    public function itemsList()
    {
        $items = Item::all();
        return view('pages.items.index', compact('items'));
    }

    public function itemOrderCard(Item $item)
    {
        $popularItems = Item::orderBy('item_sold', 'desc')->take(5)->get();
        return view('pages.items.item_order', compact('item', 'popularItems'));
    }

    public function itemAddToCart(Request $request, Item $item)
    {
        $cartQuantity = $request->input('cart_quantity', 1);
        $cartQuantity = min($cartQuantity, $item->item_stocks);

        if ($item->item_status === 'in_stock' && $cartQuantity > 0) {
            $cart = Cart::where('cart_item_id', $item->item_id)
                        ->where('cart_user_id', auth()->user()->user_id)
                        ->first();
            if ($cart) {
                $cart->increment('cart_quantity', $cartQuantity);
                $cart->cart_sub_total = $cart->cart_quantity * $item->item_price;
                $cart->save();
            } else {
                Cart::create([
                    'cart_item_id'      => $item->item_id,
                    'cart_user_id'      => auth()->user()->user_id,
                    'cart_quantity'     => $cartQuantity,
                    'cart_sub_total'    => $item->item_price * $cartQuantity
                ]);
            }
            $item->decrement('item_stocks', $cartQuantity);

            return redirect()->route('items')->with('success', 'Item added to cart successfully');
        }
        return redirect()->back()->with('error', 'Item is out of stock or invalid quantity');
    }

    public function itemsOrderCheckOut(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        $quantities = $request->input('cart_quantity', []);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'No items selected for checkout.');
        }

        $carts = Cart::whereIn('cart_id', $selectedItems)
                      ->where('cart_user_id', Auth::id())
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
                $cart->cart_quantity = $quantities[$cart->cart_id];
                $cart->cart_sub_total = $cart->cart_quantity * $item->item_price;
                $cart->save();

                $item->decrement('item_stocks', $cart->cart_quantity);

                $shipmentItems[] = [
                    'cart_item_id' => $item->item_id,
                    'cart_quantity' => $cart->cart_quantity,
                    'cart_sub_total' => $cart->cart_sub_total
                ];
            }
            $totalAmount += $cart->cart_sub_total;
        }

        session([
            'itemsCheckout' => $selectedItems
        ]);
        return redirect()->route('item-orderSummary');
    }

    public function itemOrderSummary()
    {
        $selectedItems = session('itemsCheckout', []);
        $carts = Cart::whereIn('cart_id', $selectedItems)
                     ->where('cart_user_id', Auth::id())
                     ->with('item')
                     ->get();
        $totalAmount = $carts->sum('cart_sub_total');
        $customer = Auth::user();

        return view('pages.items.item_order_summary', compact('selectedItems', 'carts', 'totalAmount', 'customer'));
    }
}
