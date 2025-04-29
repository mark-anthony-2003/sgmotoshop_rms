@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-4xl px-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                Item Details
            </h2>

            <div class="bg-white border rounded-xl shadow-sm p-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex justify-center md:justify-start">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}" class="w-64 h-64 object-cover rounded-lg">
                        @else
                            <div class="flex items-center justify-center w-64 h-64 bg-gray-100 rounded-lg">
                                <span class="text-gray-400">No Image Available</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ Str::title($item->item_name) }}</h2>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="font-medium text-gray-500">Price:</div>
                            <div class="text-gray-800 font-semibold">Php {{ number_format($item->price, 2) }}</div>

                            <div class="font-medium text-gray-500">Stocks:</div>
                            <div class="text-gray-800">{{ number_format($item->stocks) }}</div>

                            <div class="font-medium text-gray-500">Sold:</div>
                            <div class="text-gray-800">{{ number_format($item->sold) }}</div>

                            <div class="font-medium text-gray-500">Status:</div>
                            <div>
                                <span class="inline-flex items-center gap-x-1 py-1 px-3 rounded-full text-xs font-medium 
                                    {{ $item->item_status === 'in_stock' ? 'bg-teal-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $item->item_status))) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
