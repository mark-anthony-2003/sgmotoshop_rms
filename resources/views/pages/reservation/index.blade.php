@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center py-12">
        <div class="w-full max-w-6xl px-6">
            <h2 class="text-4xl font-bold text-[#222831] mb-6">Reservation Form</h2>

            <form action="{{ route('reservation.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-white p-4 rounded-lg border space-y-4">
                    <h3 class="text-2xl font-semibold text-[#222831]">Customer's Information</h3>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-[#222831] mb-1">First Name</label>
                            <input type="text" name="first_name" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('first_name', $customer->first_name) }}" disabled>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-[#222831] mb-1">Last Name</label>
                            <input type="text" name="last_name" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('last_name', $customer->last_name) }}" disabled>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-[#222831]">Address</h4>
                        <div class="grid grid-cols-4 gap-6">
                            <div>
                                <label for="barangay" class="block text-sm text-[#222831] mb-1">Barangay</label>
                                <input type="text" name="barangay" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('barangay', $address->first()->barangay ?? '') }}" disabled>
                            </div>
                            <div>
                                <label for="city" class="block text-sm text-[#222831] mb-1">City</label>
                                <input type="text" name="city" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('city', $address->first()->city ?? '') }}" disabled>
                            </div>
                            <div>
                                <label for="province" class="block text-sm text-[#222831] mb-1">Province</label>
                                <input type="text" name="province" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('province', $address->first()->province ?? '') }}" disabled>
                            </div>
                            <div>
                                <label for="country" class="block text-sm text-[#222831] mb-1">Country</label>
                                <input type="text" name="country" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('country', $address->first()->country ?? '') }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-[#222831]">Contact Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_number" class="block text-sm text-[#222831] mb-1">Contact No.</label>
                                <input type="text" name="contact_number" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded" value="{{ old('contact_number', $customer->contact_number) }}" disabled>
                            </div>
                            <div>
                                <label for="email" class="block text-sm text-[#222831] mb-1">Email Address (optional)</label>
                                <input type="email" name="email" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg border space-y-6">
                    <h3 class="text-2xl font-semibold text-[#222831]">Available Services</h3>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left">
                                <thead class="bg-gray-50 text-sm text-[#222831]">
                                    <tr>
                                        <th class="px-4 py-2">Service Offered</th>
                                        <th class="px-4 py-2">Cost/Price</th>
                                        <th class="px-4 py-2">Select</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @forelse ($serviceTypes as $serviceType)
                                        <tr>
                                            <td class="px-4 py-2">{{ $serviceType->service_name }}</td>
                                            <td class="px-4 py-2">₱{{ number_format($serviceType->price, 2) }}</td>
                                            <td class="px-4 py-2">
                                                <input 
                                                    type="checkbox"
                                                    class="service_checkbox h-4 w-4 text-primary accent-gray-700"
                                                    data-price="{{ $serviceType->price }}"
                                                    data-name="{{ $serviceType->service_name }}"
                                                    value="{{ $serviceType->service_type_id }}"
                                                    name="serviceTypes[]">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-[#222831]">No Services Available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-[#222831] mb-2">Selected Services</h4>
                            <ul id="selected_services" class="list-disc pl-5 text-[#222831] space-y-1 mb-3"></ul>
                            <div class="text-lg font-bold text-[#222831]">
                                Total: ₱<span id="total_price">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 bg-white p-4 rounded-lg border space-y-4">
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-[#222831]">Transaction Date</h4>
                        <input type="date" name="preferred_date" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                    </div>
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-[#222831]">Payment Method</h4>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="cash" class="form-radio text-primary accent-gray-700">
                                <span class="ml-2 text-sm text-[#222831]">Cash</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="gcash" class="form-radio text-primary accent-gray-700">
                                <span class="ml-2 text-sm text-[#222831]">Gcash</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                        Submit Reservation
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll(".service_checkbox")
        const totalPrice = document.getElementById("total_price")
        const selectedServices = document.getElementById("selected_services")

        const updateTotal = () => {
            let total = 0;
            selectedServices.innerHTML = ""
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.dataset.price)
                    const li = document.createElement("li")
                    li.textContent = checkbox.dataset.name
                    selectedServices.appendChild(li)
                }
            })
            totalPrice.textContent = total.toFixed(2)
        }
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", updateTotal)
        })
    })
</script>
@endpush
