@extends('includes.app')

@section('content')
<section class="flex justify-center items-start mt-20">
    <div class="w-full max-w-6xl px-4 space-y-6">
        <h2 class="text-4xl font-semibold text-gray-800">Order Summary</h2>

        <div class="bg-white border border-gray-200 rounded-md p-6 shadow-sm">
            <h4 class="text-lg font-semibold mb-2 text-gray-800">Customer Information</h4>
            <p class="text-gray-700">Name: {{ $customer->first_name }} {{ $customer->last_name }}</p>
            <p class="text-gray-700">Contact No: {{ $customer->contact_number }}</p>

            @if($customer->addresses->first())
                <p class="text-gray-700">
                    <strong>Address:</strong>
                    {{ $customer->addresses->first()->barangay }},
                    {{ $customer->addresses->first()->city }},
                    {{ $customer->addresses->first()->province }},
                    {{ $customer->addresses->first()->country }}
                </p>
            @else
                <p class="text-gray-500 italic">No address available</p>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white border border-gray-200 rounded-md p-6 shadow-sm space-y-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Items in Your Cart</h4>
                @foreach ($carts as $cart)
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $cart->item->image) }}" 
                             alt="{{ $cart->item->item_name }}" 
                             class="w-20 h-20 object-cover rounded-md border" />
                        
                        <div class="flex-1">
                            <h5 class="text-lg font-medium text-gray-800">{{ Str::title($cart->item->item_name) }}</h5>
                            <p class="text-gray-600"><strong>Quantity:</strong> {{ $cart->quantity }}</p>
                            <p class="text-gray-600"><strong>Subtotal:</strong> ₱{{ number_format($cart->sub_total, 2) }}</p>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr class="border-t border-gray-200">
                    @endif
                @endforeach
            </div>

            <div class="bg-white border border-gray-200 rounded-md p-6 shadow-sm space-y-6 h-fit">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Order Summary</h4>
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span>₱{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-800">
                        <span>Total:</span>
                        <span>₱{{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>

                <div>
                    <form action="{{ route('items.ship') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">

                        <div class="space-y-2">
                            <h4 class="text-lg font-semibold text-gray-800">Shipment Method</h4>
                            <select name="shipment_method" id="shipment_method" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                <option value="">Select Method</option>
                                <option value="courier" selected>Courier</option>
                                <option value="on_site_pickup">On-site Pickup</option>
                            </select>

                            <h4 class="text-lg font-semibold text-gray-800">Payment Method</h4>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="payment_method" value="gcash" required class="accent-gray-700">
                                <span>Gcash</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="payment_method" value="cash_on_delivery" required class="accent-gray-700">
                                <span>Cash on Delivery</span>
                            </label>
                        </div>

                        <div class="flex justify-end items-center space-x-4 pt-4 border-t border-gray-200">
                            <span class="text-gray-700 text-sm">Total ({{ count($selectedItems) }} items)</span>
                            <button type="submit" class="ml-auto px-4 py-2 bg-[#222831] text-white text-sm rounded disabled:opacity-50">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
