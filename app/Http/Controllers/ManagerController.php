<?php

namespace App\Http\Controllers;

use App\Models\Laborer;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function managerProfile($managerId)
    {
        $user = auth()->user();
        if ($user->user_type !== 'employee' || 
            strtolower($user->employee->positionType->position_name ?? '') !== 'manager' || 
            $user->user_id != $managerId) {
            abort(403, 'Unauthorized access.');
        }

        $manager = $user->employee;
        return view('pages.profile.employees.manager.index', compact('manager'));
    }

    public function managerPanel()
    {
        $reservations = ServiceDetail::with(['serviceType', 'service', 'laborer.employee.user'])->get();
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
            'manager_remarks'        => 'Rejected due to availability issues.'
        ]);

        return redirect()->back()->with('success', 'Reservation rejected.');
    }

    public function assignLaborer(Request $request, $serviceDetailId)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,employee_id'
        ]);
    
        $serviceDetail = ServiceDetail::findOrFail($serviceDetailId);
        if ($serviceDetail->approval_type !== 'approved') {
            return redirect()->back()->with('error', 'Reservation must be approved first.');
        }
    
        $serviceDetail->update([
            'employee_id' => $request->employee_id
        ]);
    
        return redirect()->back()->with('success', 'Laborer assigned successfully.');
    }

    public function paymentStatus(Request $request, $service_detail_id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed'
        ]);
    
        $serviceDetail = ServiceDetail::with('service')->findOrFail($service_detail_id);
    
        $service = $serviceDetail->service;
        if ($service) {
            $service->payment_status = $request->payment_status;
            $service->save();
    
            return redirect()->back()->with('success', 'Payment status updated successfully.');
        }
    
        return redirect()->back()->with('error', 'Related service not found.');
    }
    
}
