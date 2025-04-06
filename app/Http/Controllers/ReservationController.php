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

        dump($serviceTypes);

        return view(
            'pages.reservation.index',
            compact('customer', 'address', 'serviceTypes')
        );
    }

    public function makeReservation(Request $request)
    {
        $request->validate([
            'serviceTypes' => 'required|array',
            'serviceTypes.*' => 'exists:service_types,service_type_id',
            'parts' => 'nullable|array',
            'parts.*' => 'exists|part_id,part_name',
            'service_payment_method' => 'required|in:cash,gcash',
            'service_payment_ref_no' => 'nullable|string',
            'service_preferred_date' => 'required|date'
        ]);

        $totalAmount = ServiceType::whereIn('service_type_id', $request->serviceTypes)
            ->sum('service_type_price');

        $service = Service::create([
            'service_total_amount'      => $totalAmount,
            'service_payment_method'    => $request->service_payment_method,
            'service_payment_status'    => 'pending',
            'service_payment_ref_no'    => $request->service_payment_ref_no,
            'service_preferred_date'    => $request->service_preferred_date 
        ]);

        ServiceTransaction::create([
            'service_transaction_user_id' => Auth::id(),
            'service_transaction_service_id' => $service->service_id,
            'service_transaction_employee_id' => null
        ]);

        foreach ($request->serviceTypes as $serviceTypeId) {
            ServiceDetail::create([
                'service_detail_service_id'         => $service->service_id,
                'service_detail_service_type_id'    => $serviceTypeId,
                'service_detail_part_id'            => null
            ]);
        }

        if ($request->has('parts')) {
            foreach ($request->parts as $partId) {
                ServiceDetail::create([
                    'service_detail_service_id'         => $service->service_id,
                    'service_detail_service_type_id'    => null,
                    'service_detail_part_id'            => $partId
                ]);
            }
        }

        return redirect()->route('customer-panel')->with('success', 'Reservation successful');
    }
}
