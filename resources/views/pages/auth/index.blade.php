@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-xs px-4 py-4">
            <h2 class="text-2xl font-semibold text-center text-[#222831] mb-4">Sign in</h2>

            <div class="space-y-2">
                <a href="{{ route('sign-in.customer') }}" class="block w-full px-3 py-2.5 text-sm text-center font-medium text-white bg-[#30475E] rounded-sm transition duration-150">
                    Customer
                </a>
                <a href="{{ route('sign-in.employee-as') }}" class="block w-full px-3 py-2.5 text-sm text-center font-medium text-white bg-[#30475E] rounded-sm transition duration-150">
                    Employee
                </a>
            </div>
        </div>
    </section>
@endsection
