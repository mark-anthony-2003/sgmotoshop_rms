@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-lg p-4">
            <h2 class="text-4xl font-semibold text-center text-[#222831] mb-4">SG Motopshop</h2>

            <div class="flex items-center justify-center gap-6">
                <a href="{{ route('items') }}" class="w-full px-3 py-2.5 text-sm text-center font-medium text-white bg-[#30475E] rounded-sm transition duration-150">
                    Order Items
                </a>
                <a href="{{ route('reservation-form') }}" class="w-full px-3 py-2.5 text-sm text-center font-medium text-white bg-[#30475E] rounded-sm transition duration-150">
                    Make a Reservation
                </a>
            </div>
        </div>
    </section>
@endsection

