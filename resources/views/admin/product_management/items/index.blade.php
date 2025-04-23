@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#222831] mb-5">Items Table</h2>
                <a href="{{ route('item.create.form') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white">
                    Add New Item
                </a>
            </div>
            

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Item Name</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Stocks</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Sold</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Item Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($itemsList as $index => $item )
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ Str::title($item->item_name) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ number_format($item->price, 2) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ number_format($item->stocks) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ number_format($item->sold) }}</td>
                                            <td class="px-6 py-2 whitespace-nowrapfont-medium text-gray-800">
                                                <span class="inline-flex items-center gap-x-1 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                                    {{ $item->item_status === 'in_stock' ? 'bg-teal-500' : 'bg-red-500' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $item->item_status))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-gray-800 hover:underline">Info</a>
                                                <a href="{{ route('item.edit', $item) }}" class="text-gray-800 hover:underline">Edit</a>
                                                <form action="{{ route('item-delete', $item) }}" method="post">
                                                    @csrf
                                                    <button type="submit" id="hs-new-toast" class="text-red-800 hover:underline">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="7">No Items Available</td>
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
