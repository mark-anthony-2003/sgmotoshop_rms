<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\PendingReservation;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceTransaction;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function reservationForm()
    {
        $customer = Auth::user();
        $address = $customer->addresses;
        $serviceTypes = ServiceType::all();

        return view('pages.reservation.index', compact('customer', 'address', 'serviceTypes'));
    }

    public function makeReservation(Request $request)
    {
        $request->validate([
            'serviceTypes'          => 'required|array',
            'serviceTypes.*'        => 'exists:service_types,service_type_id',
            'parts'                 => 'nullable|array',
            'parts.*'               => 'exists:parts,part_id',
            'payment_method'        => 'required|in:cash,gcash',
            'payment_reference'     => 'nullable|string',
            'preferred_date'        => 'required|date',
        ]);

        $totalAmount = ServiceType::whereIn('service_type_id', $request->serviceTypes)->sum('price');

        if ($request->payment_method === 'gcash') {
            session()->put('reservation_payment_data', [
                'user_id'           => Auth::id(),
                'serviceTypes'      => $request->serviceTypes,
                'parts'             => $request->parts,
                'preferred_date'    => $request->preferred_date,
                'total_amount'      => $totalAmount,
            ]);
            return redirect()->route('gcash.reservation.checkout');
        }

        return $this->storeReservation($request, $totalAmount, 'cash', 'pending', null);
    }

    public function storeReservation($request, $totalAmount, $paymentMethod, $paymentStatus, $paymentReference)
    {
        DB::beginTransaction();
    
        try {
            $service = Service::create([
                'total_amount'      => $totalAmount,
                'payment_method'    => $paymentMethod,
                'payment_status'    => $paymentStatus,
                'payment_reference' => $paymentReference,
                'preferred_date'    => $request->preferred_date,
            ]);
    
            ServiceTransaction::create([
                'user_id'       => Auth::id(),
                'service_id'    => $service->service_id,
            ]);
    
            foreach ($request->serviceTypes ?? [] as $serviceTypeId) {
                ServiceDetail::create([
                    'service_id'      => $service->service_id,
                    'service_type_id' => $serviceTypeId,
                    'part_id'         => null,
                ]);
                Inventory::create([
                    'inventory_type'    => 'service type',
                    'inventoryable_id'  => $serviceTypeId,
                    'amount'            => -1,
                ]);
            }
    
            foreach ($request->parts ?? [] as $partId) {
                ServiceDetail::create([
                    'service_id'      => $service->service_id,
                    'service_type_id' => null,
                    'part_id'         => $partId,
                ]);
                Inventory::create([
                    'inventory_type'    => 'part',
                    'inventoryable_id'  => $partId,
                    'amount'            => -1,
                ]);
            }
    
            DB::commit();
            return redirect()->route('customer.panel')->with('success', 'Reservation successful.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process reservation.');
        }
    }
    

    public function initiateGcashReservationPayment()
    {
        $user = Auth::user();
        $reservationData = session('reservation_payment_data');

        if (!$reservationData || empty($reservationData['total_amount'])) {
            return redirect()->route('reservation.form')->with('error', 'Reservation session expired or invalid.');
        }

        $pending = PendingReservation::create([
            'user_id' => $user->user_id,
            'data'    => json_encode($reservationData),
        ]);

        $lineItems = [[
            'amount'    => (int) round($reservationData['total_amount'] * 100),
            'currency'  => 'PHP',
            'name'      => 'Reservation Payment',
            'quantity'  => 1
        ]];

        $redirectUrl = route('gcash.reservation.success', ['id' => $pending->id]);
        $cancelUrl = route('reservation.form');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name'  => $user->first_name . ' ' . $user->last_name,
                            'email' => $user->email,
                            'phone' => $user->contact_number,
                        ],
                        'line_items'           => $lineItems,
                        'payment_method_types' => ['gcash'],
                        'success_url'          => $redirectUrl,
                        'cancel_url'           => $cancelUrl,
                        'description'          => 'Reservation via GCash',
                    ]
                ]
            ]);

            $paymentData = $response->json();
            if (isset($paymentData['data']['attributes']['checkout_url'])) {
                return redirect($paymentData['data']['attributes']['checkout_url']);
            }

            return redirect()->back()->with('error', 'Failed to initiate GCash reservation payment.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'GCash payment error: ' . $e->getMessage());
        }
    }

    public function gcashReservationSuccess($id)
    {
        $user = Auth::user();
        $pending = PendingReservation::find($id);
    
        if (!$pending || $pending->user_id !== $user->user_id) {
            return redirect()->route('reservation.form')->with('error', 'Invalid reservation session.');
        }
    
        $data = json_decode($pending->data, true);
    
        if (!isset($data['total_amount'])) {
            return redirect()->route('reservation.form')->with('error', 'Total amount is missing or invalid.');
        }
    
        try {
            return $this->storeReservation(
                (object)[
                    'serviceTypes' => $data['serviceTypes'] ?? [],
                    'parts' => $data['parts'] ?? [],
                    'preferred_date' => $data['preferred_date'] ?? null
                ],
                $data['total_amount'],
                'gcash',
                'completed',
                'GCASH-' . strtoupper(Str::random(10))
            );
    
        } catch (\Exception $e) {
            return redirect()->route('reservation.form')->with('error', 'Something went wrong while finalizing your reservation.');
        }
    }
    
}
