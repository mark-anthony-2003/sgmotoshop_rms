@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-4xl px-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                Equipment Details
            </h2>

            <div class="bg-white border border-gray-200 rounded-md p-6 space-y-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    {{ Str::title($equipment->equipment_name) }}
                </h3>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700">
                    <div>
                        <dt class="font-medium text-gray-600">Purchase Date</dt>
                        <dd class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($equipment->purchase_date)->format('F j, Y') }}</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-600">Maintenance Date</dt>
                        <dd class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($equipment->maintenance_date)->format('F j, Y') }}</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-600">Status</dt>
                        <dd class="mt-1 text-gray-900">
                            <span class="inline-flex items-center gap-x-1 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                {{ $equipment->equipment_status === 'operational' ? 'bg-teal-500' : 'bg-red-500' }}">
                                {{ strtoupper(ucfirst(str_replace('_', ' ', $equipment->equipment_status))) }}
                            </span>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-600">Laborer Assignee</dt>
                        <dd class="mt-1 text-gray-900">
                            {{ $equipment->employee->user->first_name }} {{ $equipment->employee->user->last_name }}
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="font-medium text-gray-600">Service</dt>
                        <dd class="mt-1 text-gray-900">{{ $equipment->service->service_name }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
@endsection
