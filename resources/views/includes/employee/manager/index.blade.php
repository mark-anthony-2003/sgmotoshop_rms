@extends('includes.app')

@section('title', 'Manager Panel')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-8xl px-6">
            <h2 class="text-4xl font-bold text-[#222831] mb-6">Manager Panel</h2>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Type</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Approval</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Assign Laborer</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Payment Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($reservations as $index => $reservation)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ Str::title($reservation->serviceType->service_name) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium text-white 
                                                    {{ $reservation->approval_type === 'approved' ? 'bg-teal-500' : 
                                                    ($reservation->approval_type === 'rejected' ? 'bg-red-500' : 
                                                    'bg-yellow-500') }}">
                                                    {{ ucfirst($reservation->approval_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800">
                                                @if ($reservation->approval_type === 'approved')
                                                    <form action="{{ route('laborer.assign', $reservation->service_detail_id) }}" method="POST">
                                                        @csrf
                                                        <select name="employee_id" class="mr-2 px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                                            <option value="">Select Laborer</option>
                                                            @foreach ($laborers as $laborer)
                                                                <option value="{{ $laborer->employee_id }}" @if($reservation->employee_id == $laborer->employee_id) selected @endif>
                                                                    {{ $laborer->employee->user->first_name }} {{ $laborer->employee->user->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-blue-500 text-white">
                                                            Assign
                                                        </button>
                                                    </form>
                                                @else
                                                    <em class="text-gray-400">Approve first</em>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800">
                                                <form action="{{ route('manager.payment.status', $reservation->service_detail_id) }}" method="POST">
                                                    @csrf
                                                    <select name="payment_status" class="mr-2 px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                                        <option value="">Select Payment Status</option>
                                                        <option value="pending" {{ old('payment_status', $reservation->service->payment_status ?? '') == 'pending' ? 'selected' : '' }}>
                                                            Pending
                                                        </option>
                                                        <option value="completed" {{ old('payment_status', $reservation->service->payment_status ?? '') == 'completed' ? 'selected' : '' }}>
                                                            Completed
                                                        </option>
                                                    </select>
                                                    <button type="submit" class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-blue-500 text-white">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800">
                                                @if ($reservation->approval_type === 'pending')
                                                    <form action="{{ route('manager.approve', $reservation->service_detail_id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-teal-500 text-white">
                                                            Approve
                                                          </button>
                                                    </form>
    
                                                    <button 
                                                        type="button"
                                                        data-hs-overlay="#reject-modal-{{ $reservation->service_detail_id }}"
                                                        class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md bg-red-500 text-white hover:bg-red-600">
                                                        Reject
                                                    </button>
                                                    <div id="reject-modal-{{ $reservation->service_detail_id }}" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                                                        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-14 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                                                            <div class="relative flex flex-col bg-white shadow-lg rounded-xl p-6">
                                                                <div class="flex justify-between items-center">
                                                                    <h3 class="text-xl font-bold text-gray-800">Reject Reservation</h3>
                                                                    <button type="button" class="text-gray-400 hover:text-gray-600" data-hs-overlay="#reject-modal-{{ $reservation->service_detail_id }}">
                                                                        <span class="sr-only">Close</span>
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                    
                                                                <div class="mt-4 mb-6">
                                                                    <p class="text-gray-600">
                                                                        Are you sure you want to reject this reservation? <br> This action cannot be undone.
                                                                    </p>
                                                                </div>
                                                    
                                                                <div class="flex justify-end gap-2">
                                                                    <button type="button" class="py-2 px-4 text-gray-800 hover:bg-gray-100 rounded-md border border-gray-300" data-hs-overlay="#reject-modal-{{ $reservation->service_detail_id }}">
                                                                        Cancel
                                                                    </button>
                                                                    <form action="{{ route('manager.reject', $reservation->service_detail_id) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="py-2 px-4 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                                            Yes, Reject
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                @else
                                                    <em class="text-gray-400">No actions available</em>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No reservations found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

