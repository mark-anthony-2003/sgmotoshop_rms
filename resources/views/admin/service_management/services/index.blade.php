@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">Services Table</h2>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Service Name</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($serviceTypesList as $index => $serviceType)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ Str::title($serviceType->service_type_name) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ number_format($serviceType->service_type_price, 2) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrapfont-medium text-gray-800">
                                                <span class="inline-flex items-center gap-x-1 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                                    {{ $serviceType->service_type_status === 'available' ? 'bg-teal-500' : 'bg-red-500' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $serviceType->service_type_status))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                                <form action="{{ route('serviceType-delete', $serviceType) }}" method="post">
                                                    @csrf
                                                    <button type="submit" id="hs-new-toast" class="text-red-800 underline">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="7">No Services Available</td>
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
