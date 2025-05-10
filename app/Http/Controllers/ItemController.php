<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\InventoryLogger;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemsTable()
    {
        $itemsList = Item::all();
        return view('admin.product_management.items.index', compact('itemsList'));
    }

    public function itemDetail(Item $item)
    {
        return view('admin.product_management.items.show', compact('item'));
    }

    public function itemForm()
    {
        return view('admin.product_management.items.create');
    }

    public function itemCreate(Request $request)
    {
        $validated = $request->validate([
            'item_name'     => 'required|string|max:100',
            'price'         => 'required|integer',
            'stocks'        => 'required|integer',
            'sold'          => 'required|integer',
            'image'         => 'nullable|image|mimes:png,jpg|max:5000',
            'item_status'   => 'required|in:in_stock,out_of_stock',
        ]);

        $validated['item_status'] = ($validated['stocks'] == 0) ? 'out_of_stock' : 'in_stock';

        $itemImagePath = null;
        if ($request->hasFile('image')) {
            $itemImagePath = $request->file('image')->store('item_images', 'public');
        }

        $item = Item::create([
            'item_name'     => $validated['item_name'],
            'price'         => $validated['price'],
            'stocks'        => $validated['stocks'],
            'sold'          => $validated['sold'],
            'image'         => $itemImagePath,
            'item_status'   => $validated['item_status']
        ]);

        InventoryLogger::log([
            'item_id'      => $item->item_id,
            'employee_id'  => auth()->user()->employee->employee_id ?? null,
            'source_type'  => 'sales',
            'source_id'    => $item->item_id,
            'quantity'     => $item->stocks,
            'movement_type'=> 'in',
            'remarks'      => 'New item created',
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
            'price'         => 'required|integer',
            'stocks'        => 'required|integer',
            'sold'          => 'required|integer',
            'item_status'   => 'required|in:in_stock,out_of_stock',
        ]);

        $itemImagePath = $item->item_image;
        if ($request->hasFile('image')) {
            $itemImagePath = $request->file('image')->store('item_images', 'public');
        }

        $item->update([
            'item_name'     => $validated['item_name'],
            'price'         => $validated['price'],
            'stocks'        => $validated['stocks'],
            'sold'          => $validated['sold'],
            'image'         => $itemImagePath,
            'item_status'   => $validated['item_status']
        ]);

        $quantityChange = $validated['stocks'] - $item->stocks;
        if ($quantityChange != 0) {
            InventoryLogger::log([
                'item_id'      => $item->item_id,
                'employee_id'  => auth()->user()->employee->employee_id ?? null,
                'source_type'  => 'sales',
                'source_id'    => $item->item_id,
                'quantity'     => $quantityChange,
                'movement_type'=> $quantityChange > 0 ? 'in' : 'out',
                'remarks'      => 'Item stock adjusted',
            ]);
        }

        return redirect()->route('items.table')->with('success', 'Item updated successfully');
    }

    public function itemDelete(Item $item)
    {
        $item->delete();

        InventoryLogger::log([
            'item_id'      => $item->item_id,
            'employee_id'  => auth()->user()->employee->employee_id ?? null,
            'source_type'  => 'sales',
            'source_id'    => $item->item_id,
            'quantity'     => -$item->stocks,
            'movement_type'=> 'out',
            'remarks'      => 'Item deleted',
        ]);

        return redirect()->route('items.table')->with('success', 'Item deleted successfully');
    }
}
