@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl p-4">
            <h2 class="text-4xl font-semibold text-start text-[#222831] mb-4">Services</h2>

            <div class="grid grid-cols-5 gap-4">
                @forelse ($services as $service)
                    <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-md">
                        <a href="{{ route('reservation.form') }}">
                            @if ($service->image)
                                <img 
                                    src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->service_name }}"
                                    class="w-full h-auto rounded-t-md">
                            @else
                                <div>No Image Available</div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-[#222831]"> {{ Str::title($service->service_name) }} </h3>
                                <p class="mt-1 text-[#222831]"> ₱{{ number_format($service->price, 2) }} </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p>No services available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
