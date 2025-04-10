@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl p-4">
            <h2 class="text-4xl font-semibold text-start text-[#222831] mb-4">Order Item</h2>

            <div class="p-2 rounded-md max-w-2xl mx-auto m-4t mb-8 bg-white shadow-sm">
                <div class="flex flex-row gap-4">
                    <div class="w-full flex items-center justify-center bg-gray-100 rounded-md overflow-hidden">
                        @if ($item->item_image)
                            <img 
                                src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80"
                                alt="{{ $item->item_name }}"
                                class="object-cover">
                        @else
                            <div class="text-gray-500 text-sm text-center p-4">No Image Available</div>
                        @endif
                    </div>
                    <div class="w-full flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-[#222831]">{{ Str::title($item->item_name) }}</h3>
                            <p class="mt-1 text-[#222831]">₱{{ number_format($item->item_price, 2) }}</p>
                            <p class="mt-5 text-xs text-[#222831]">{{ $item->item_sold }} sold</p>
                            <span
                                class="mt-1 inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium text-white
                                    {{ $item->item_status == 'out_of_stock' ? 'bg-red-500' : 'bg-teal-500' }}">
                                {{ strtoupper(ucfirst(str_replace('_', ' ', $item->item_status))) }}
                            </span>
                        </div>
            
                        <form action="{{ route('item-addToCart', $item->item_id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="flex items-center gap-2">
                                <button type="button"
                                    onclick="changeItemQuantity(-1)"
                                    class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-200 disabled:opacity-50"
                                    {{ $item->item_status === 'out_of_stock' ? 'disabled' : '' }}>-</button>
            
                                <input type="number" name="cart_quantity" id="cart_quantity"
                                    min="1" max="{{ $item->item_stocks }}" value="1"
                                    class="w-16 border text-center rounded py-1">
            
                                <button type="button"
                                    onclick="changeItemQuantity(1)"
                                    class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-200 disabled:opacity-50"
                                    {{ $item->item_status === 'out_of_stock' ? 'disabled' : '' }}>+</button>
            
                                <button type="submit"
                                    class="ml-auto px-4 py-2 bg-[#222831] text-white text-sm rounded disabled:opacity-50"
                                    {{ $item->item_status === 'out_of_stock' ? 'disabled' : '' }}>
                                    Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            

            <div>
                <h3 class="text-2xl font-semibold text-start text-[#222831] mb-4">You might also like</h3>
                
                <div class="grid grid-cols-5 gap-4">
                    @foreach ($popularItems as $popularItem)
                        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-md">
                            <a href="{{ route('item-order', $popularItem->item_id) }}">
                                @if ($popularItem->item_image)
                                    <img 
                                        src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80"
                                        alt="{{ $popularItem->item_name }}"
                                        class="w-full h-auto rounded-t-md">
                                @else
                                    <div>No Image Available</div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-800"> {{ Str::title($popularItem->item_name) }} </h3>
                                    <p class="mt-1 text-[#222831]"> ₱{{ number_format($popularItem->item_price, 2) }} </p>
                                    <p class="mt-5 text-xs text-gray-500"> <span> {{ $popularItem->item_sold }} sold </span> </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const changeItemQuantity = (amount) => {
        const cartQuantityInput = document.getElementById('cart_quantity')
        if (!cartQuantityInput) return

        let currentValue = parseInt(cartQuantityInput.value) || 1
        const maxVal = parseInt(cartQuantityInput.max) || Infinity
        const minVal = parseInt(cartQuantityInput.min) || 1

        currentValue += amount
        if (currentValue < minVal) currentValue = minVal
        if (currentValue > maxVal) currentValue = maxVal

        cartQuantityInput.value = currentValue
    }
</script>
@endpush
