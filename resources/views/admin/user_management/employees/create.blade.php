@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                {{ isset($employee) ? 'Update Employee Information' : 'New Employee Registration' }}
            </h2>

            <div class="flex justify-center items-center">
                <form action="{{ isset($employee) ? route('employee.update', $employee->employee_id) : route('employee.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-lg border space-y-4 w-5xl">
                    @csrf

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-[#222831] mb-1">Profile Image</label>
                            <input type="file" name="profile_image" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('profile_image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="first_name" class="block text-sm font-medium text-[#222831] mb-1">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $employee->user->first_name ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('first_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-[#222831] mb-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $employee->user->last_name ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-[#222831] mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $employee->user->email ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-[#222831] mb-1">Password</label>
                            <input type="password" name="password" id="password" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-end mt-1">
                                <input type="checkbox" id="show_password" class="h-4 w-4 text-[#30475E] border-gray-300 rounded" onclick="togglePasswordVisibility()">
                                <label for="show_password" class="ml-2 text-sm text-[#222831]">Show Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-[#222831] mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->user->date_of_birth ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('date_of_birth') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-[#222831] mb-1">Contact No.</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number', $employee->user->contact_number ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('contact_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        @php
                            $currentUserStatus = old('user_status');
                            if (!$currentUserStatus && isset($employee) && $employee->user && $employee->user->user_status) {
                                $currentUserStatus = $employee->user->user_status;
                            }
                        @endphp
                        <div>
                            <label for="user_status" class="block text-sm font-medium text-[#222831] mb-1">User Status</label>
                            <select name="user_status" id="user_status" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                <option disabled {{ old('user_status', $currentUserStatus) === '' ? 'selected' : '' }}>Select Status</option>
                                <option value="active" {{ old('user_status', $currentUserStatus) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('user_status', $currentUserStatus) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('user_status', $currentUserStatus) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('user_status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>                        
                        
                        @php
                            $currentAddressType = old('address_type');
                            if (!$currentAddressType && isset($employee) && $employee->user && $employee->user->addresses->isNotEmpty()) {
                                $currentAddressType = $employee->user->addresses->first()->address_type;
                            }
                        @endphp
                        <div>
                            <label for="address_type" class="block text-sm font-medium text-[#222831] mb-1">Address Type</label>
                            <select name="address_type" id="address_type" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                <option disabled {{ old('address_type', $currentAddressType) === '' ? 'selected' : '' }}>Select Type</option>
                                <option value="home" {{ old('address_type', $currentAddressType) === 'home' ? 'selected' : '' }}>Home</option>
                                <option value="work" {{ old('address_type', $currentAddressType) === 'work' ? 'selected' : '' }}>Work</option>
                            </select>
                            @error('address_type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-[#222831] mb-4">Address</h4>

                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                @php
                                    $defaultCountry = old('country') ?? ($employee?->user?->addresses?->first()?->country ?? 'Philippines');
                                @endphp
                                <label for="country" class="block text-sm font-medium text-[#222831] mb-1">Country</label>
                                <select name="country" id="country" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="{{ $defaultCountry }}" selected> {{ $defaultCountry }} </option>
                                </select>
                                @error('country') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                @php
                                    $defaultProvince = old('province') ?? ($employee?->user?->addresses?->first()?->province ?? 'Select State/Province');
                                @endphp
                                <label for="province" class="block text-sm font-medium text-[#222831] mb-1">Province</label>
                                <select name="province" id="province" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="{{ $defaultProvince }}" selected> {{ $defaultProvince }} </option>
                                </select>
                                @error('province') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                @php
                                    $defaultCity = old('city') ?? ($employee?->user?->addresses?->first()?->city ?? 'Select City/Municipality');
                                @endphp
                                <label for="city" class="block text-sm font-medium text-[#222831] mb-1">City</label>
                                <select name="city" id="city" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="{{ $defaultCity }}" selected> {{ $defaultCity }} </option>
                                </select>
                                @error('city') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                @php
                                    $defaultBarangay = old('barangay') ?? ($employee?->user?->addresses?->first()?->barangay ?? 'Select Street/Barangay');
                                @endphp
                                <label for="barangay" class="block text-sm font-medium text-[#222831] mb-1">Barangay</label>
                                <select name="barangay" id="barangay" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="{{ $defaultBarangay }}" selected> {{ $defaultBarangay }} </option>
                                </select>
                                @error('barangay') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-[#222831] mb-4">Employment</h4>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="position_type" class="block text-sm font-medium text-[#222831] mb-1">Position</label>
                                <select name="position_type_id" id="position_type" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                    <option disabled {{ old('position_type_id', $employee->position_type_id ?? null) ? '' : 'selected' }}>
                                        Select Position
                                    </option>
                                    @foreach ($positions as $position)
                                        <option 
                                            value="{{ $position->position_type_id }}"
                                            {{ (string) old('position_type_id', $employee->position_type_id ?? '') === (string) $position->position_type_id ? 'selected' : '' }}>
                                            
                                            {{ ucfirst($position->position_name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_type_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            @php
                                $currentEmploymentStatus = old('employment_status');
                                if (!$currentEmploymentStatus && isset($employee) && $employee->employment_status) {
                                    $currentEmploymentStatus = $employee->employment_status;
                                }
                            @endphp
                            <div>
                                <label for="employment_status" class="block text-sm font-medium text-[#222831] mb-1">Employment Status</label>
                                <select name="employment_status" id="employment_status" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                    <option disabled {{ old('employment_status', $currentEmploymentStatus) === '' ? 'selected' : '' }}>Select Status</option>
                                    <option value="active" {{ old('employment_status', $currentEmploymentStatus) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="on_leave" {{ old('employment_status', $currentEmploymentStatus) === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="resigned" {{ old('employment_status', $currentEmploymentStatus) === 'resigned' ? 'selected' : '' }}>Resigned</option>
                                </select>
                                @error('employment_status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            @php
                                $currentWork = old('work');                            
                                if (!$currentWork && isset($employee) && $employee->laborer && $employee->laborer->work) {
                                    $currentWork = $employee->laborer->work;
                                }
                            @endphp
                            <div>
                                <label for="work" class="block text-sm font-medium text-[#222831] mb-1">Work</label>
                                <select name="work" id="work" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                    <option value="" {{ old('work', $currentWork) === '' ? 'selected' : '' }}>
                                        Select Work
                                    </option>
                                    <option value="Mechanic" {{ old('work', $currentWork) === 'Mechanic' ? 'selected' : '' }}>
                                        Mechanic
                                    </option>
                                    <option value="Auto Electrician" {{ old('work', $currentWork) === 'Auto Electrician' ? 'selected' : '' }}>
                                        Auto Electrician
                                    </option>
                                    <option value="Transmission Specialist" {{ old('work', $currentWork) === 'Transmission Specialist' ? 'selected' : '' }}>
                                        Transmission Specialist
                                    </option>
                                    <option value="Welder" {{ old('work', $currentWork) === 'Welder' ? 'selected' : '' }}>
                                        Welder
                                    </option>
                                    <option value="Tire Technician" {{ old('work', $currentWork) === 'Tire Technician' ? 'selected' : '' }}>
                                        Tire Technician
                                    </option>
                                    <option value="Oil Change Specialist" {{ old('work', $currentWork) === 'Oil Change Specialist' ? 'selected' : '' }}>
                                        Oil Change Specialist
                                    </option>
                                </select>
                                @error('work') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label for="salary_type_id" class="block text-sm font-medium text-[#222831] mb-1">Salary Type</label>
                                <select name="salary_type_id" id="salary_type" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                    <option disabled {{ old('salary_type_id', $employee->salary_type_id ?? null) ? '' : 'selected' }}>
                                        Select Salary Type
                                    </option>
                                    @foreach ($salaries as $salary)
                                        <option
                                            value="{{ $salary->salary_type_id }}"
                                            {{ (string) old('salary_type_id', $employee->salary_type_id ?? '') === (string) $salary->salary_type_id ? 'selected' : '' }}>
                                            
                                            {{ ucfirst(str_replace('_', ' ', $salary->salary_name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('salary_type_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="monthly_rate" class="block text-sm font-medium text-[#222831] mb-1">Regular Salary</label>
                                <input type="number" name="monthly_rate" id="monthly_rate" value="{{ old('monthly_rate', $employee->regularSalary->monthly_rate ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                @error('monthly_rate') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div style="display: none">
                                <label for="daily_rate" class="block text-sm font-medium text-[#222831] mb-1">Daily Rate</label>
                                <input type="number" name="daily_rate" id="daily_rate" value="{{ old('daily_rate', $employee->perDaySalary->daily_rate ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                @error('daily_rate') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div style="display: none">
                                <label for="days_worked" class="block text-sm font-medium text-[#222831] mb-1">Days Worked</label>
                                <input type="number" name="days_worked"  id="days_worked" value="{{ old('days_worked', $employee->perDaySalary->days_worked ?? '') }}" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                @error('days_worked') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                            {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const togglePasswordVisibility = () => {
        const passwordInput = document.getElementById('password')
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password'
    }

    document.addEventListener('DOMContentLoaded', function () {
        const positionTypeSelect = document.getElementById('position_type')
        const workContainer = document.getElementById('work')?.closest('div')
        const salaryTypeSelect = document.getElementById('salary_type')
        const monthlyRateField = document.getElementById('monthly_rate')?.closest('div')
        const dailyRateField = document.getElementById('daily_rate')?.closest('div')
        const daysWorkedField = document.getElementById('days_worked')?.closest('div')

        function toggleWorkAndStatusFields() {
            const selectedText = positionTypeSelect?.selectedOptions[0]?.textContent.trim().toLowerCase()
            
            if (selectedText === 'laborer') {
                workContainer.style.display = 'block'
            } else {
                workContainer.style.display = 'none'
                document.getElementById('work').value = ''
            }
        }

        function toggleSalaryTypeAndSalaryFields() {
            const selectedText = salaryTypeSelect?.selectedOptions[0]?.textContent.trim().toLowerCase()

            if (selectedText === 'regular') {
                monthlyRateField.style.display = 'block'
                dailyRateField.style.display = 'none'
                daysWorkedField.style.display = 'none'
            } else if (selectedText === 'per day') {
                monthlyRateField.style.display = 'none'
                dailyRateField.style.display = 'block'
                daysWorkedField.style.display = 'block'
            } else {
                monthlyRateField.style.display = 'none'
                dailyRateField.style.display = 'none'
                daysWorkedField.style.display = 'none'
            }
        }

        toggleWorkAndStatusFields()
        toggleSalaryTypeAndSalaryFields()
        positionTypeSelect?.addEventListener('change', toggleWorkAndStatusFields)
        salaryTypeSelect?.addEventListener('change', toggleSalaryTypeAndSalaryFields)
    })

    $(document).ready(function () {
        const oldProvince = "{{ old('province', $employee?->user?->addresses?->first()?->province ?? '') }}"
        const oldCity = "{{ old('city', $employee?->user?->addresses?->first()?->city ?? '') }}"
        const oldBarangay = "{{ old('barangay', $employee?->user?->addresses?->first()?->barangay ?? '') }}"

        $.get('/address/provinces', function (data) {
            $('#province').empty().append('<option value="">Select Province</option>')
            data.forEach(function (item) {
                const selected = item.name === oldProvince ? 'selected' : ''
                $('#province').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
            })

            if (oldProvince) {
                $('#province').trigger('change')
            }
        })

        $('#province').on('change', function () {
            const code = $('#province option:selected').data('code')
            if (!code) return

            $('#city').empty().append('<option value="">Select City/Town</option>')
            $('#barangay').empty().append('<option value="">Select Barangay</option>')

            $.get(`/address/cities/${code}`, function (data) {
                data.forEach(function (item) {
                    const selected = item.name === oldCity ? 'selected' : ''
                    $('#city').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
                })

                if (oldCity) {
                    $('#city').trigger('change');
                }
            })
        })

        $('#city').on('change', function () {
            const code = $('#city option:selected').data('code')
            if (!code) return

            $('#barangay').empty().append('<option value="">Select Barangay</option>')

            $.get(`/address/barangays/${code}`, function (data) {
                data.forEach(function (item) {
                    const selected = item.name === oldBarangay ? 'selected' : ''
                    $('#barangay').append(`<option value="${item.name}" ${selected}>${item.name}</option>`)
                })
            })
        })
    })

</script>
@endpush
