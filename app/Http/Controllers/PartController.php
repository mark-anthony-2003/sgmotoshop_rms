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

    public function partForm()
    {
        return view('admin.service_management.parts.create');
    }

    public function partCreate(Request $request)
    {
        $validated = $request->validate([
            'part_name'     => 'required|string|max:100'
        ]);

        $part = Part::create([
            'part_name'     => $validated['part_name']
        ]);

        if ($part) {
            return redirect()->back()->withErrors(['error', 'Failed to store part.']);
        }
        return redirect()->route('parts.table')->with('success', 'Part created successfully');
    }

    public function partEdit(Part $part)
    {
        return view('admin.service_management.parts.create', compact('part'));
    }

    public function partUpdate(Request $request, Part $part)
    {
        $validated = $request->validate([
            'part_name'     => 'required|string|max:100'
        ]);

        $part->update([
            'part_name'     => $validated['part_name']
        ]);

        return redirect()->route('parts.table')->with('success', 'Part updated successfully');
    }

    public function partDelete(Part $part)
    {
        $part->delete();
        return redirect()->route('parts.table')->with('success', 'Part deleted successfully');
    }
}
