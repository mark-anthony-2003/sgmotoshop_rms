@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                {{ isset($equipment) ? 'Update Equipment' : 'New Equipment' }}
            </h2>

            <div class="flex justify-center items-center">
                <form action="{{ isset($equipment) ? route('equipment.update', $equipment->equipment_id) : route('equipment.store') }}" method="POST" class="bg-white p-4 rounded-lg border space-y-4 w-4xl">
                    @csrf

                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <label for="equipment_name" class="block text-sm font-medium text-[#222831] mb-1">Equipment Name</label>
                            <input type="text" name="equipment_name" value="{{ old('equipment_name', $equipment->equipment_name ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('equipment_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-[#222831] mb-1">Purchase Date</label> 
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', $equipment->purchase_date ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('purchase_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="maintenance_date" class="block text-sm font-medium text-[#222831] mb-1">Maintenance Date</label> 
                            <input type="date" name="maintenance_date" value="{{ old('maintenance_date', $equipment->maintenance_date ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('maintenance_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <label for="equipment_status" class="block text-sm text-[#222831] mb-1">Equipment Status</label>
                            <select name="equipment_status" id="equipment_status" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md">
                                <option value="">Select Status</option>
                                <option value="operational" {{ old('equipment_status', $equipment->equipment_status ?? '') == 'operational' ? 'selected' : '' }}>
                                    Operational
                                </option>
                                <option value="under_repair" {{ old('equipment_status', $equipment->equipment_status ?? '') == 'under_repair' ? 'selected' : '' }}>
                                    Under Repair
                                </option>
                                <option value="out_of_service" {{ old('equipment_status', $equipment->equipment_status ?? '') == 'out_of_service' ? 'selected' : '' }}>
                                    Out of Service
                                </option>
                            </select>
                            @error('equipment_status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-[#222831] mb-1">Assign to Employee</label>
                            <select name="employee_id" id="employee_id" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                <option selected>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option 
                                        value="{{ $employee->employee_id }}"
                                        {{ (string) old('employee_id', $employee->employee_id ?? '') === (string) $employee->employee_id ? 'selected' : '' }}>
                                        {{ $employee->user->first_name }} {{ $employee->user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="service_id" class="block text-sm font-medium text-[#222831] mb-1">Service</label>
                            <select name="service_id" id="service_id" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                <option selected>Select Service</option>
                                @foreach ($services as $service)
                                    <option 
                                        value="{{ $service->service_type_id }}"
                                        {{ (string) old('service_id', $service->service_type_id ?? '') === (string) $service->service_type_id ? 'selected' : '' }}>
                                        {{ $service->service_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                            {{ isset($equipment) ? 'Update Equipment' : 'Create Equipment' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
