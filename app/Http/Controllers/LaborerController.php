<?php

namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class LaborerController extends Controller
{
    public function assignLaborer(Request $request, $serviceDetailId)
    {
        $request->validate([
            'laborer_id' => 'required|exists:laborers,laborer_id'
        ]);

        $serviceDetail = ServiceDetail::findOrFail($serviceDetailId);

        if ($serviceDetail->approval_type !== 'approved') {
            return redirect()->back()->with('error', 'Reservation must be approved first.');
        }

        $serviceDetail->update([
            'assigned_by_manager_id' => $request->laborer_id
        ]);

        return redirect()->back()->with('success', 'Laborer assigned succussfully.');
    }
}
