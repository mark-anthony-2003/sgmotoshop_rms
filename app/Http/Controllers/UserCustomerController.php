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
        $orders = Shipment::with(['cart.item', 'product'])->get();
        $reservations = ServiceDetail::with([
            'service',
            'serviceType'
        ])->get();

        return view('pages.profile.customer.index', compact('customer', 'orders', 'reservations'));
    }

    public function updateCustomerProfile(Request $request, $customerId)
    {
        $customer = User::findOrFail($customerId);

        $validated = $request->validate([
            'first_name'        => 'required|string|max:225',
            'last_name'         => 'required|string|max:225',
            'date_of_birth'     => 'nullable|date',
            'contact_number'    => 'nullable|string|max:20',
            'profle_image'      => 'nullable|image|mimes:png,jpg|max:5000',
            'country'           => 'required|string|max:100',
            'province'          => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'barangay'          => 'required|string|max:100',
            'address_type'      => 'required|in:home,work'
        ]);

        $customerImagePath = $customer->profile_image;
        if ($request->hasFile('profile_image')) {
            $customerImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $customer->update([
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'date_of_birth'     => $validated['date_of_birth'] ?? $customer->date_of_birth,
            'contact_number'    => $validated['contact_number'] ?? $customer->contact_no,
            'profile_image'     => $customerImagePath
        ]);
        $customer->addresses()->updateOrCreate(
            ['address_type' => $validated['address_type']],
            [
                'barangay'  => $validated['barangay'],
                'city'      => $validated['city'],
                'province'  => $validated['province'],
                'country'   => $validated['country'],
            ]
        );

        return redirect()->route('customer.profile', $customer->user_id)->with('success', 'Profile updated successfully');
    }
}
