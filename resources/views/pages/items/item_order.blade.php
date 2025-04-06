@extends('includes.app')

@section('content')
    <h2>Order Item</h2>

    <div style="border: 1px solid black;">
        <div>
            @if ($item->item_image)
                <img src="" alt="{{ $item->item_name }}">
            @else
                <div>No Image Available</div>
            @endif
        </div>
        <div>
            <h5> {{ $item->item_name }} </h5>
            <p> {{ $item->item_price }} </p>
            <p> <span> {{ $item->item_sold }} sold </span> </p>
            <p>
                <span> {{ ucfirst(str_replace('_', ' ', $item->item_status)) }} </span>
            </p>

            <form action="{{ route('item-addToCart', $item->item_id) }}" method="post">
                @csrf
                <div>
                    <button
                        type="button"
                        onclick="changeItemQuantity(-1)"
                        {{ $item->item_status === 'out_of_stock' ? 'disabled' : '' }}>-</button>
                    <input 
                        type="number"
                        name="cart_quantity"
                        id="cart_quantity"
                        min="1"
                        max="{{ $item->item_stocks }}"
                        value="1">
                    <button
                        type="button"
                        onclick="changeItemQuantity(1)"
                        {{ $item->item_status === 'out_of_stock' ? 'disabled' : '' }}>+</button>

                    <button
                        type="submit"
                        {{ $item->item_status === 'out_of_stock' ? 'disabled' : '' }}>Add to Cart</button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div>
            <h3>You might also like</h3>
        </div>
        
        @foreach ($popularItems as $popularItem)
            <div style="border: 1px solid black;">
                <a href="{{ route('item-order', $popularItem->item_id) }}">
                    <div>
                        @if ($popularItem->item_image)
                            <img src="" alt="{{ $popularItem->item_name }}">
                        @else
                            <div>No Image Available</div>
                        @endif
                        <div>
                            <h5> {{ Str::title($popularItem->item_name) }} </h5>
                            <p> ₱{{ $popularItem->item_price }} </p>
                            <p> <span> {{ $popularItem->item_sold }} sold </span> </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

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
@endsection
