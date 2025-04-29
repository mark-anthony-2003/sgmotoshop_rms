@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#222831] mb-5">Services Table</h2>
                <a href="{{ route('serviceType.create.form') }}" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                    Add New Service
                </a>
            </div>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Image</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Name</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($serviceTypesList as $index => $serviceType)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                                @if ($serviceType->image)
                                                    <img src="{{ asset('storage/' . $serviceType->image) }}" alt="{{ $serviceType->service_name }}" class="w-35 h-20 object-cover rounded-lg">
                                                @else
                                                    <p class="text-gray-400">No Image Available</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ Str::title($serviceType->service_name) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ number_format($serviceType->price, 2) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrapfont-medium text-gray-800">
                                                <span class="inline-flex items-center gap-x-1 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                                    {{ $serviceType->service_status === 'available' ? 'bg-teal-500' : 'bg-red-500' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $serviceType->service_status))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('serviceType.show', $serviceType) }}" class="text-gray-800 hover:underline px-1">Info</a>
                                                <a href="{{ route('serviceType.edit', $serviceType) }}" class="text-gray-800 hover:underline px-1">Edit</a>

                                                <button 
                                                    type="button"
                                                    data-hs-overlay="#delete-modal-{{ $serviceType->service_type_id }}"
                                                    class="text-red-800 hover:underline px-1">
                                                    Delete
                                                </button>
                                                <div id="delete-modal-{{ $serviceType->service_type_id }}" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                                                    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-14 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                                                        <div class="relative flex flex-col bg-white shadow-lg rounded-xl p-6">
                                                            <div class="flex justify-between items-center">
                                                                <h3 class="text-xl font-bold text-gray-800">
                                                                    Delete Confirmation
                                                                </h3>
                                                                <button type="button" class="text-gray-400 hover:text-gray-600" data-hs-overlay="#delete-modal-{{ $serviceType->service_type_id }}">
                                                                    <span class="sr-only">Close</span>
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <div class="mt-4 mb-6">
                                                                <p class="text-gray-600">
                                                                    Are you sure you want to delete this item? <br> This action cannot be undone.
                                                                </p>
                                                            </div>

                                                            <div class="flex justify-end gap-2">
                                                                <button type="button" class="py-2 px-4 text-gray-800 hover:bg-gray-100 rounded-md border border-gray-300" data-hs-overlay="#delete-modal-{{ $serviceType->service_type_id }}">
                                                                    Cancel
                                                                </button>
                                                                <form action="{{ route('serviceType.delete', $serviceType) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" id="hs-new-toast" class="py-2 px-4 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="7" class="text-center">No Services Available</td>
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

@push('scripts')
    @if (session('success'))
        <script>
            Toastify({
                text: "✅ {{ session('success') }}",
                duration: 3000,
                gravity: "top", 
                position: "right", 
                backgroundColor: "#16a34a", // green-600
                stopOnFocus: true,
                className: "rounded-lg shadow text-sm px-4 py-2 text-white font-medium"
            }).showToast();
        </script>
    @endif
@endpush
