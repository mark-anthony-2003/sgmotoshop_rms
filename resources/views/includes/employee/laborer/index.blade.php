@extends('includes.app')

@section('title', 'Laborer Panel')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-8xl px-6">
            <h2 class="text-4xl font-bold text-[#222831] mb-6">Laborer Panel</h2>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Type</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Assignee</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Preferred Date</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Remarks</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($reservations as $index => $reservation)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ Str::title($reservation->serviceType->service_name) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ $reservation->laborer->employee->user->first_name }} {{ $reservation->laborer->employee->user->last_name }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ \Carbon\Carbon::parse($reservation->service->preferred_date)->format('F j, Y') }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $reservation->manager_remarks }}</td>
                                        </tr>
                                    @empty
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No Transaction</td>
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

