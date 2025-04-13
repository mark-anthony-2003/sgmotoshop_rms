@extends('includes.app')

@section('title', 'Manager Panel')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-6">
            <h2 class="text-4xl font-bold text-[#222831] mb-6">Manager Panel</h2>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service ID</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Type</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Approval</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Assign Laborer</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($reservations as $reservation)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $reservation->service_detail_id }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $reservation->serviceType->service_type_name ?? 'N/A' }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium text-white 
                                                    {{ $reservation->st_approval_type === 'approved' ? 'bg-teal-500' : 
                                                    ($reservation->st_approval_type === 'rejected' ? 'bg-red-500' : 
                                                    'bg-yellow-500') }}">
                                                    {{ ucfirst($reservation->st_approval_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800">
                                                @if ($reservation->st_approval_type === 'approved')
                                                <form action="{{ route('laborer.assign', $reservation->service_detail_id) }}" method="POST">
                                                    @csrf
                                                    <select name="laborer_id" class="rounded border-gray-300">
                                                        <option value="">Select Laborer</option>
                                                        @foreach ($laborers as $laborer)
                                                            <option value="{{ $laborer->laborer_id }}">
                                                                {{ $laborer->employee->user->user_first_name }} {{ $laborer->employee->user->user_last_name }}
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
                                                @if ($reservation->st_approval_type === 'pending')
                                                    <form action="{{ route('manager.approve', $reservation->service_detail_id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-teal-500 text-white">
                                                            Approve
                                                          </button>
                                                    </form>
    
                                                    <form action="{{ route('manager.reject', $reservation->service_detail_id) }}" method="POST" class="inline ml-2">
                                                        @csrf
                                                        <button type="submit" class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-red-500 text-white">
                                                            Reject
                                                        </button>
                                                    </form>
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
