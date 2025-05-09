@extends('includes.app')

@section('content')
    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl p-4">
            <h2 class="text-4xl font-semibold text-start text-[#222831] mb-4">Items</h2>

            <div class="grid grid-cols-5 gap-4">
                @forelse ($items as $item)
                    <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-md">
                        <a href="{{ route('item.order', $item->item_id) }}">
                            @if ($item->image)
                                <img 
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->item_name }}"
                                    class="w-full h-auto rounded-t-md">
                            @else
                                <div>No Image Available</div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-[#222831]"> {{ Str::title($item->item_name) }} </h3>
                                <p class="mt-1 text-[#222831]"> ₱{{ number_format($item->price, 2) }} </p>
                                <p class="mt-5 text-xs text-gray-500"> <span> {{ $item->sold }} sold </span> </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p>No items available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
