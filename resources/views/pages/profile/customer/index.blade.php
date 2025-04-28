@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">Customer Profile</h2>

            <div class="flex">
                <div class="flex bg-gray-100 hover:bg-gray-200 rounded-lg transition p-1">
                    <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                        <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-[#222831] py-2.5 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 font-medium rounded-md disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white active" id="segment-item-1" aria-selected="true" data-hs-tab="#segment-1" aria-controls="segment-1" role="tab">
                            User Settings
                        </button>
                        <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-[#222831] py-2.5 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 font-medium rounded-md disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" id="segment-item-2" aria-selected="false" data-hs-tab="#segment-2" aria-controls="segment-2" role="tab">
                            Orders History
                        </button>
                        <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-[#222831] py-2.5 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 font-medium rounded-md disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" id="segment-item-3" aria-selected="false" data-hs-tab="#segment-3" aria-controls="segment-3" role="tab">
                            Reservations History
                        </button>
                    </nav>
                </div>
            </div>

            <div class="mt-3">
                <div id="segment-1" role="tabpanel" aria-labelledby="segment-item-1">
                    <form action="{{ route('customer.update', $customer->user_id) }}" method="post" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="image" class="block text-sm text-[#222831]">Profile Image</label>
                                    <input type="file" name="image" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                </div>
            
                                <div>
                                    <label for="first_name" class="block text-sm text-[#222831]">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                </div>
            
                                <div>
                                    <label for="last_name" class="block text-sm text-[#222831]">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                </div>
            
                                <div>
                                    <label for="email" class="block text-sm text-[#222831]">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                </div>
            
                                <div>
                                    <label for="contact_number" class="block text-sm text-[#222831]">Contact No</label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number', $customer->contact_number) }}" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                </div>
            
                                <div>
                                    <label for="date_of_birth" class="block text-sm text-[#222831]">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-[#222831] mb-4">Address</h4>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label for="country" class="block text-sm text-[#222831]">Country</label>
                                    <select name="country" id="country" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                        <option value="{{ old('country', $customer->addresses->first()->country ?? 'Philippines') }}" selected>
                                            {{ old('country', $customer->addresses->first()->country ?? 'Philippines') }}
                                        </option>
                                    </select>
                                </div>
            
                                <div>
                                    <label for="province" class="block text-sm text-[#222831]">State/Province</label>
                                    <select name="province" id="province" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                        <option value="{{ old('province', $customer->addresses->first()->province ?? 'Select State/Province') }}" selected>
                                            {{ old('province', $customer->addresses->first()->province ?? 'Select State/Province') }}
                                        </option>
                                    </select>
                                </div>
            
                                <div>
                                    <label for="city" class="block text-sm text-[#222831]">City/Town</label>
                                    <select name="city" id="city" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                        <option value="{{ old('city', $customer->addresses->first()->city ?? 'Select City/Municipality') }}" selected>
                                            {{ old('city', $customer->addresses->first()->city ?? 'Select City/Municipality') }}
                                        </option>
                                    </select>
                                </div>
            
                                <div>
                                    <label for="barangay" class="block text-sm text-[#222831]">Barangay</label>
                                    <select name="barangay" id="barangay" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                        <option value="{{ old('barangay', $customer->addresses->first()->barangay ?? 'Select Street/Barangay') }}" selected>
                                            {{ old('barangay', $customer->addresses->first()->barangay ?? 'Select Street/Barangay') }}
                                        </option>
                                    </select>
                                </div>
            
                                <div>
                                    <label for="address_type" class="block text-sm text-[#222831] mb-1">Address Type</label>
                                    <select name="address_type" id="address_type" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                        <option value="">Select Type</option>
                                        <option value="home" {{ old('address_type', $customer->addresses->first()->address_type ?? '') == 'home' ? 'selected' : '' }}>Home</option>
                                        <option value="work" {{ old('address_type', $customer->addresses->first()->address_type ?? '') == 'work' ? 'selected' : '' }}>Work</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                <div id="segment-2" class="hidden" role="tabpanel" aria-labelledby="segment-item-2">
                    <p class="text-gray-500">
                        This is the <em class="font-semibold text-gray-800">second</em> item's tab body.
                    </p>
                </div>
                <div id="segment-3" class="hidden" role="tabpanel" aria-labelledby="segment-item-3">
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Type</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Preferred Date</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Approval Status</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Payment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @php
                                                $groupedReservations = $reservations->groupBy(fn($r) => $r->service->service_id);
                                                $rowCounter = 1;
                                            @endphp
                                        
                                            @foreach ($groupedReservations as $serviceId => $group)
                                                @php
                                                    $groupTotal = $group->sum(fn($r) => $r->serviceType->price);
                                                    $serviceDetails = $group->first()->service;
                                                @endphp
                                        
                                                @foreach ($group as $reservation)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $rowCounter++ }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $reservation->serviceType->service_name }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">₱{{ number_format($reservation->serviceType->price, 2) }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-500 text-white uppercase">
                                                                {{ $reservation->serviceType->service_status }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                            {{ \Carbon\Carbon::parse($reservation->service->preferred_date)->format('F d, Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                                                    {{ $reservation->approval_type === 'approved' ? 'bg-teal-500' : 'bg-red-500' }}">
                                                                {{ $reservation->approval_type }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 uppercase">
                                                            {{ $reservation->service->payment_method }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 uppercase">
                                                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">
                                                                {{ $reservation->service->payment_status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                                <tr class="bg-gray-100">
                                                    <td colspan="2"></td>
                                                    <td class="px-6 py-4 font-bold text-sm text-gray-800 text-start">
                                                        Total: ₱{{ number_format($groupTotal, 2) }}
                                                    </td>
                                                    <td colspan="5"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        const userAddressProvince = "{{ old('province', $customer->addresses->first()->province ?? '') }}"
        const userAddressCity = "{{ old('city', $customer->addresses->first()->city ?? '') }}"
        const userAddressBarangay = "{{ old('barangay', $customer->addresses->first()->barangay ?? '') }}"

        $.get('/address/provinces', function (data) {
            $('#province').empty().append('<option>Select State/Province</option>')
            data.forEach(function (item) {
                const selected = item.name === userAddressProvince ? 'selected' : ''
                $('#province').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
            })

            if (userAddressProvince) $('#province').trigger('change')
        })

        $('#province').change(function () {
            const code = $('#province option:selected').data('code')
            const name = $(this).val()

            $('#city').html('<option>Select City/Town</option>')
            $('#barangay').html('<option>Select Barangay</option>')

            if (!code) return

            $.get(`/address/cities/${code}`, function (data) {
                $('#city').empty().append('<option>Select City/Town</option>')
                data.forEach(function (item) {
                    const selected = item.name === userAddressCity ? 'selected' : ''
                    $('#city').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
                })

                if (userAddressCity) $('#city').trigger('change')
            })
        })

        $('#city').change(function () {
            const code = $('#city option:selected').data('code')
            const name = $(this).val()

            $('#barangay').html('<option>Select Barangay</option>')
            if (!code) return

            $.get(`/address/barangays/${code}`, function (data) {
                $('#barangay').empty().append('<option>Select Barangay</option>')
                data.forEach(function (item) {
                    const selected = item.name === userAddressBarangay ? 'selected' : ''
                    $('#barangay').append(`<option value="${item.name}" ${selected}>${item.name}</option>`)
                })
            })
        })
    })
</script>
@endpush
