<?php

namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;

class UserCustomerController extends Controller
{
    public function customerProfile($customerId)
    {
        $user = User::findOrFail($customerId);
        $orderItems = Shipment::all();
        $reservations = ServiceDetail::with(['service', 'serviceType'])->get();

        return view('pages.profile.customer.index', compact('user', 'orderItems', 'reservations'));
    }
}
