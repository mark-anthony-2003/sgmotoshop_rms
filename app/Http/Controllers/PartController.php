<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function partsTable()
    {
        $partsList = Part::all();
        return view('admin.service_management.parts.index', compact('partsList'));
    }

    public function partDelete(Part $part)
    {
        $part->delete();
        return redirect()->route('parts-table')->with('success', 'Part deleted successfully');
    }
}
