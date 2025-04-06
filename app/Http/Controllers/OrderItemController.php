<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function itemsList()
    {
        $items = Item::all();
        return view('pages.items.index', compact('items'));
    }

    public function itemOrderCard(Item $item)
    {
        $popularItems = Item::orderBy('item_sold', 'desc')->take(6)->get();
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
}
