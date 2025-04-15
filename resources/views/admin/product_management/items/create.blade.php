@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                {{ isset($item) ? 'Update Item' : 'New Item' }}
            </h2>

            <form action="{{ isset($item) ? route('item.update', $item->item_id) : route('item.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="item_name">Item Name</label>
                    <input type="text" name="item_name" value="{{ old('item_name', $item->item_name ?? '') }}">
                </div>
            </form>
        </div>
    </section>
@endsection
