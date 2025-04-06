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

    public function itemDelete(Item $item)
    {
        $item->delete();
        return redirect()->route('items-table')->with('success', 'Item deleted successfully');
    }
}
