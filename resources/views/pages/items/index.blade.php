@extends('includes.app')

@section('content')
    <h2>Items</h2>

    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <section style="display: grid; gap: 10px;">
        @forelse ($items as $item)
            <div style="border: 1px solid black;">
                <a href="{{ route('item-order', $item->item_id) }}">
                    <div>
                        @if ($item->item_image)
                            <img src="" alt="{{ $item->item_name }}">
                        @else
                            <div>No Image Available</div>
                        @endif
                        <div>
                            <h5> {{ Str::title($item->item_name) }} </h5>
                            <p> ₱{{ $item->item_price }} </p>
                            <p> <span> {{ $item->item_sold }} sold </span> </p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p>No items available at the moment.</p>
        @endforelse
    </section>
@endsection
