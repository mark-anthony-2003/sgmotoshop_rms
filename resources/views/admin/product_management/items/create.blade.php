@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                {{ isset($item) ? 'Update Item' : 'New Item' }}
            </h2>

            <div class="flex justify-center items-center">
                <form
                    action="{{ isset($item) ? route('item.update', $item->item_id) : route('item.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="bg-white p-4 rounded-lg border space-y-4 w-4xl">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="item_name" class="block text-sm font-medium text-[#222831] mb-1">Item Name</label>
                            <input type="text" name="item_name" value="{{ old('item_name', $item->item_name ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('item_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div>
                            <label for="price" class="block text-sm font-medium text-[#222831] mb-1">Price</label>
                            <input type="number" name="price" value="{{ old('price', $item->price ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('price')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="stocks" class="block text-sm font-medium text-[#222831] mb-1">Stocks</label>
                            <input type="number" name="stocks" value="{{ old('stocks', $item->stocks ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('stocks')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="item_status" class="block text-sm text-[#222831] mb-1">Item Status</label>
                            <select name="item_status" id="item_status" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                <option value="">Select Status</option>
                                <option value="in_stock" {{ old('item_status', $item->item_status ?? '') == 'in_stock' ? 'selected' : '' }}>
                                    In Stock
                                </option>
                                <option value="out_of_stock" {{ old('item_status', $item->item_status ?? '') == 'out_of_stock' ? 'selected' : '' }}>
                                    Out of Stock
                                </option>
                            </select>
                            @error('item_status')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="image" class="block text-sm font-medium text-[#222831] mb-1">Image</label>
                            <input type="file" name="image" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('image')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sold" class="block text-sm font-medium text-[#222831] mb-1">Sold</label>
                            <input type="number" name="sold" value="{{ old('sold', $item->sold ?? 0) }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('sold')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                            {{ isset($item) ? 'Update Item' : 'Create Item' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stocksInput = document.querySelector('input[name="stocks"]')
        const statusSelect = document.querySelector('select[name="item_status"]')

        function updateItemStatus() {
            if (parseInt(stocksInput.value) === 0) {
                statusSelect.value = 'out_of_stock'
            } else if (statusSelect.value === '' || statusSelect.value === 'out_of_stock') {
                statusSelect.value = 'in_stock'
            }
        }

        stocksInput.addEventListener('input', updateItemStatus)

        updateItemStatus()
    })
</script>
@endpush
