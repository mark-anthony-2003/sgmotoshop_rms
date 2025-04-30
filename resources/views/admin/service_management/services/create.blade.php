@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                {{ isset($serviceType) ? 'Update Service Type' : 'New Service Type' }}
            </h2>

            <div class="flex justify-center items-center">
                <form action="{{ isset($serviceType) ? route('serviceType.update', $serviceType->service_type_id) : route('serviceType.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-lg border space-y-4 w-4xl">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="service_name" class="block text-sm font-medium text-[#222831] mb-1">Service Name</label>
                            <input type="text" name="service_name" value="{{ old('service_name', $serviceType->service_name ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('service_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-[#222831] mb-1">Price</label>
                            <input type="number" name="price" value="{{ old('price', $serviceType->price ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="image" class="block text-sm font-medium text-[#222831] mb-1">Image</label>
                            <input type="file" name="image" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="service_status" class="block text-sm text-[#222831] mb-1">Service Status</label>
                            <select name="service_status" id="service_status" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                <option value="">Select Status</option>
                                <option value="available" {{ old('service_status', $serviceType->service_status ?? '') == 'available' ? 'selected' : '' }}>
                                    Available
                                </option>
                                <option value="not_available" {{ old('service_status', $serviceType->service_status ?? '') == 'not_available' ? 'selected' : '' }}>
                                    Not Available
                                </option>
                            </select>
                            @error('service_status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                            {{ isset($serviceType) ? 'Update Service Type' : 'Create Service Type' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
