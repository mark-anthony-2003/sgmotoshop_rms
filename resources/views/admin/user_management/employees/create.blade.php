@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">
                New Employee Registration
            </h2>

            <div class="flex justify-center items-center">
                <form 
                    action="{{ route('employee.create') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="bg-white p-4 rounded-lg border space-y-4 w-5xl">
                    @csrf

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-[#222831] mb-1">Profile Image</label>
                            <input type="file" name="profile_image" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('profile_image')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="first_name" class="block text-sm font-medium text-[#222831] mb-1">First Name</label>
                            <input type="text" name="first_name" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('first_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-[#222831] mb-1">Last Name</label>
                            <input type="text" name="last_name" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('last_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-[#222831] mb-1">Email</label>
                            <input type="email" name="email" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('email')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-[#222831] mb-1">Password</label>
                            <input type="password" name="password" id="password" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('password')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                            <div class="flex items-center justify-end mt-1">
                                <input type="checkbox" id="show_password" class="h-4 w-4 text-[#30475E] border-gray-300 rounded" onclick="togglePasswordVisibility()">
                                <label for="show_password" class="ml-2 text-sm text-[#222831]">Show Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-[#222831] mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('date_of_birth')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-[#222831] mb-1">Contact No.</label>
                            <input type="text" name="contact_number" class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                            @error('contact_number')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input type="hidden" name="address_type" value="home">
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-[#222831] mb-4">Address</h4>

                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label for="country" class="block text-sm font-medium text-[#222831] mb-1">Country</label>
                                <select name="country" id="country" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="Philippines" selected>Philippines</option>
                                </select>
                                @error('country')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="province" class="block text-sm font-medium text-[#222831] mb-1">Province</label>
                                <select name="province" id="province" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="">Select Province</option>
                                </select>
                                @error('province')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-[#222831] mb-1">City</label>
                                <select name="city" id="city" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="">Select City</option>
                                </select>
                                @error('city')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="barangay" class="block text-sm font-medium text-[#222831] mb-1">Barangay</label>
                                <select name="barangay" id="barangay" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded">
                                    <option value="">Select Barangay</option>
                                </select>
                                @error('barangay')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-[#222831] mb-4">Employment</h4>

                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label for="position_type_id" class="block text-sm font-medium text-[#222831] mb-1">Position</label>
                                <select name="position_type_id" id="position_type_id"
                                    class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                    <option disabled selected>Select Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->position_type_id }}">
                                            {{ ucfirst($position->position_name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_type_id')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="salary_type_id" class="block text-sm font-medium text-[#222831] mb-1">Salary Type</label>
                                <select name="salary_type_id" id="salary_type_id"
                                    class="block w-full px-3 py-1.5 text-sm border border-gray-300 rounded bg-white">
                                    <option disabled selected>Select Salary Type</option>
                                    @foreach ($salaries as $salary)
                                        <option value="{{ $salary->salary_type_id }}">
                                            {{ ucfirst(str_replace('_', ' ', $salary->salary_name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('salary_type_id')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                            Create Employee
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
        const passwordInput = document.getElementById('password');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }

    $(document).ready(function () {
        const oldProvince = "{{ old('province') }}"
        const oldCity = "{{ old('city') }}"
        const oldBarangay = "{{ old('barangay') }}"

        // Fetch provinces on load
        $.get('/address/provinces', function (data) {
            $('#province').empty().append('<option value="">Select Province</option>')
            data.forEach(function (item) {
                const selected = item.name === oldProvince ? 'selected' : '';
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
