<?php

namespace App\Http\Controllers;

use App\Models\Laborer;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function managerPanel()
    {
        $reservations = ServiceDetail::with('serviceType')->get();
        $laborers = Laborer::with('employee.user')->get();

        return view('includes.employee.manager.index', compact('reservations', 'laborers'));
    }

    public function approveReservation($serviceDetailId)
    {
        $transaction = ServiceDetail::findOrFail($serviceDetailId);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        $transaction->update([
            'approval_type'          => 'approved',
            'assigned_by_manager_id' => Auth::id(),
            'manager_remarks'        => 'Approved by manager.'
        ]);

        return redirect()->back()->with('success', 'Reservation approved successfully.');
    }

    public function rejectReservation($serviceDetailId)
    {
        $transaction = ServiceDetail::where('service_detail_id', $serviceDetailId)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        $transaction->update([
            'approval_type'          => 'rejected',
            'assigned_by_manager_id' => Auth::id(),
            'manager_remarks'        => 'Rejected due to availability issues.'
        ]);

        return redirect()->back()->with('success', 'Reservation rejected.');
    }
}
