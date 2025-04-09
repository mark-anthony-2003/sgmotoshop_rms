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
        $customer = User::findOrFail($customerId);
        $orderItems = Shipment::all();
        $reservations = ServiceDetail::with(['service', 'serviceType'])->get();

        return view('pages.profile.customer.index', compact('customer', 'orderItems', 'reservations'));
    }

    public function updateCustomerProfile(Request $request, $customerId)
    {
        $customer = User::findOrFail($customerId);

        $validated = $request->validate([
            'user_first_name' => 'required|string|max:225',
            'user_last_name' => 'required|string|max:225',
            'user_date_of_birth' => 'nullable|date',
            'user_contact_no' => 'nullable|string|max:20',
            'user_profle_image' => 'nullable|image|mimes:png,jpg|max:5000',
            'address_country' => 'required|string|max:100',
            'address_province' => 'required|string|max:100',
            'address_city' => 'required|string|max:100',
            'address_barangay' => 'required|string|max:100',
            'address_type' => 'required|in:home,work'
        ]);

        $customerImagePath = $customer->user_profile_image;
        if ($request->hasFile('user_profile_image')) {
            $customerImagePath = $request->file('user_profile_image')->store('user_profile_images', 'public');
        }

        $customer->update([
            'user_first_name' => $validated['user_first_name'],
            'user_last_name' => $validated['user_last_name'],
            'user_date_of_birth' => $validated['user_date_of_birth'] ?? $customer->user_date_of_birth,
            'user_contact_no' => $validated['user_contact_no'] ?? $customer->user_contact_no,
            'user_profile_image' => $customerImagePath
        ]);
        $customer->addresses()->updateOrCreate(
            ['address_type' => $validated['address_type']],
            [
                'address_barangay' => $validated['address_barangay'],
                'address_city' => $validated['address_city'],
                'address_province' => $validated['address_province'],
                'address_country' => $validated['address_country'],
            ]
        );

        return redirect()->route('customer-profile', $customer->user_id)->with('success', 'Profile updated successfully');
    }
}
