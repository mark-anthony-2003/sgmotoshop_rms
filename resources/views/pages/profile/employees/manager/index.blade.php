@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">Manager Profile</h2>

            <div class="bg-white border border-gray-200 rounded-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">User Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p class="font-medium">Name:</p>
                        <p>{{ $manager->user->first_name }} {{ $manager->user->last_name }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Email:</p>
                        <p>{{ $manager->user->email }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Date of Birth:</p>
                        <p>{{ \Carbon\Carbon::parse($manager->user->date_of_birth)->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Contact Number:</p>
                        <p>{{ $manager->user->contact_number }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="font-medium">Address:</p>
                        <p>
                            {{ $manager->user->addresses->first()->barangay }},
                            {{ $manager->user->addresses->first()->city }},
                            {{ $manager->user->addresses->first()->province }},
                            {{ $manager->user->addresses->first()->country }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-md p-6 mt-5">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Employment Status</h3>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p class="font-medium">Role:</p>
                        <p>{{ Str::title($manager->positionType->position_name) }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Salary Type:</p>
                        <p>{{ Str::title($manager->salaryType->salary_name) }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Monthly Salary:</p>
                        <p class="text-green-600 font-semibold">
                            ₱{{ number_format($manager->regularSalary->monthly_rate, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
