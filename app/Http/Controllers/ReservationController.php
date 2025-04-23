<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reservationForm()
    {
        $customer = Auth::user();
        $address = $customer->addresses;
        $serviceTypes = ServiceType::all();

        return view(
            'pages.reservation.index',
            compact('customer', 'address', 'serviceTypes')
        );
    }

    public function makeReservation(Request $request)
    {
        $request->validate([
            'serviceTypes'              => 'required|array',
            'serviceTypes.*'            => 'exists:service_types,service_type_id',
            'parts'                     => 'nullable|array',
            'parts.*'                   => 'exists|parts,part_id',
            'payment_method'            => 'required|in:cash,gcash',
            'payment_reference'         => 'nullable|string',
            'preferred_date'            => 'required|date'
        ]);

        $totalAmount = ServiceType::whereIn('service_type_id', $request->serviceTypes)
            ->sum('price');

        $service = Service::create([
            'total_amount'          => $totalAmount,
            'payment_method'        => $request->payment_method,
            'payment_status'        => 'pending',
            'payment_reference'     => $request->payment_reference,
            'preferred_date'        => $request->preferred_date
        ]);

        ServiceTransaction::create([
            'user_id' => Auth::id(),
            'service_id' => $service->service_id,
        ]);

        foreach ($request->serviceTypes as $serviceTypeId) {
            ServiceDetail::create([
                'service_id'         => $service->service_id,
                'service_type_id'    => $serviceTypeId,
                'part_id'            => null
            ]);
        }

        if ($request->has('parts')) {
            foreach ($request->parts as $partId) {
                ServiceDetail::create([
                    'service_id'         => $service->service_id,
                    'service_type_id'    => null,
                    'part_id'            => $partId
                ]);
            }
        }

        return redirect()->route('customer-panel')->with('success', 'Reservation successful');
    }
}
