<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemsTable()
    {
        $itemsList = Item::all();
        return view('admin.product_management.items.index', compact('itemsList'));
    }

    public function itemForm()
    {
        return view('admin.product_management.items.create');
    }

    public function itemCreate(Request $request)
    {
        $validated = $request->validate([
            'item_name'     => 'required|string|max:100',
            'item_price'    => 'required|integer',
            'item_stocks'   => 'required|integer',
            'item_sold'     => 'required|integer',
            'item_status'   => 'required|in:in_stock,out_of_stock',
        ]);

        $validated['item_status'] = ($validated['item_stock'] == 0) ? 'out_of_stock' : 'in_stock';

        $itemImagePath = null;
        if ($request->hasFile('item_image')) {
            $itemImagePath = $request->file('item_image')->store('item_images', 'public');
        }

        $item = Item::create([
            'item_name'     => $validated['item_name'],
            'item_price'    => $validated['item_price'],
            'item_stocks'   => $validated['item_stocks'],
            'item_sold'     => $validated['item_sold'],
            'item_image'    => $itemImagePath,
            'item_status'   => $validated['item_status']
        ]);

        if (!$item) {
            return redirect()->back()->withErrors(['error' => 'Failed to store item.']);
        }
        return redirect()->route('items.table')->with('success', 'Item created successfully');
    }

    public function itemEdit(Item $item)
    {
        return view('admin.product_management.items.create', compact('item'));
    }

    public function itemUpdate(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name'     => 'required|string|max:100',
            'item_price'    => 'required|integer',
            'item_stocks'   => 'required|integer',
            'item_sold'     => 'required|integer',
            'item_status'   => 'required|in:in_stock,out_of_stock',
        ]);

        $itemImagePath = $item->item_image;
        if ($request->hasFile('item_image')) {
            $itemImagePath = $request->file('item_image')->store('item_images', 'public');
        }

        $item->update([
            'item_name'     => $validated['item_name'],
            'item_price'    => $validated['item_price'],
            'item_stocks'   => $validated['item_stocks'],
            'item_sold'     => $validated['item_sold'],
            'item_image'    => $itemImagePath,
            'item_status'   => $validated['item_status']
        ]);

        return redirect()->route('items.table')->with('success', 'Item updated successfully');
    }


    public function itemDelete(Item $item)
    {
        $item->delete();
        return redirect()->route('items.table')->with('success', 'Item deleted successfully');
    }
}
