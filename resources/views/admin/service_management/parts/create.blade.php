@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                {{ isset($part) ? 'Update Part' : 'New Part' }}
            </h2>

            <div class="flex justify-center items-center">
                <form action="{{ isset($part) ? route('part.update', $part->part_id) : route('part.store') }}" method="POST" class="bg-white p-4 rounded-lg border space-y-4 w-4xl">
                    @csrf
    
                    <div>
                        <label for="part_name" class="block text-sm font-medium text-[#222831] mb-1">Part Name</label>
                        <input type="text" name="part_name" value="{{ old('part_name', $part->part_name ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                        @error('part_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                
                    <div class="text-right">
                        <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                            {{ isset($part) ? 'Update Part' : 'Create Part' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
