@extends('includes.app')

@section('content')
    <h2>Customer Profile</h2>

    <div>
        <form action="" method="post" enctype="multipart/form-data">
            @csrf

            <div>
                <h4>User Settings</h4>

                <div>
                    <label for="user_profile_image">Profile Image</label>
                    <input type="file" name="user_profile_image">

                    <label for="user_first_name">First Name</label>
                    <input type="text" name="user_first_name" value="{{ old('user_first_name', $user->user_first_name) }}">

                    <label for="user_last_name">Last Name</label>
                    <input type="text" name="user_last_name" value="{{ old('user_last_name', $user->user_last_name) }}">
                </div>
                <div>
                    <label for="user_email">Email Address</label>
                    <input type="email" name="user_email" value="{{ old('user_email', $user->user_email) }}">

                    <label for="user_contact_no">Contact No</label>
                    <input type="text" name="user_contact_no" value="{{ old('user_contact_no', $user->user_contact_no) }}">

                    <label for="user_date_of_birth">Date of Birth</label>
                    <input type="date" name="user_date_of_birth" value="{{ old('user_date_of_birth', $user->user_date_of_birth) }}">
                </div>
            </div>

            <div>
                <h4>Address</h4>

                <label for="address_country">Country</label>
                <select name="address_country" id="address_country">
                    <option value="{{ old('address_country', $user->addresses->first()->address_country ?? 'Philippines') }}" selected>
                        {{ old('address_country', $user->addresses->first()->address_country ?? 'Philippines') }}
                    </option>
                </select>

                <label for="address_province">State/Province</label>
                <select name="address_province" id="address_province">
                    <option value="{{ old('address_province', $user->addresses->first()->address_province ?? '') }}" selected>
                        {{ old('address_province', $user->addresses->first()->address_province ?? 'Select State/Province') }}
                    </option>
                </select>

                <label for="address_city">City/Town/Municipality</label>
                <select name="address_city" id="address_city">
                    <option value="{{ old('address_city', $user->addresses->first()->address_city ?? '') }}" selected>
                        {{ old('address_city', $user->addresses->first()->address_city ?? 'Select City/Town/Municipality') }}
                    </option>
                </select>

                <label for="address_barangay">Street/Barangay</label>
                <select name="address_barangay" id="address_barangay">
                    <option value="{{ old('address_barangay', $user->addresses->first()->address_barangay ?? '') }}" selected>
                        {{ old('address_barangay', $user->addresses->first()->address_barangay ?? 'Select Street/Barangay') }}
                    </option>
                </select>

                <label for="address_type">Address Type</label>
                <select name="address_type" id="address_type">
                    <option value="">Select Address Type</option>
                    <option value="home" {{ old('address_type', $user->addresses->first()->address_type ?? '') == 'home' ? 'selected' : '' }}>Home</option>
                    <option value="work" {{ old('address_type', $user->addresses->first()->address_type ?? '') == 'work' ? 'selected' : '' }}>Work</option>
                </select>
            </div>

            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            const userAddressProvince = "{{ old('address_province', $user->addresses->first()->address_province ?? '') }}"
            const userAddressCity = "{{ old('address_city', $user->addresses->first()->address_city ?? '') }}"
            const userAddressBarangay = "{{ old('address_barangay', $user->addresses->first()->address_barangay ?? '') }}"

            // fetch province
            $.get('/address/provinces', function(data) {
                $('#address_province').empty().append('<option>Select State/Province</option>')
                data.forEach(function(item) {
                    const selected = item.name == userAddressProvince ? 'selected' : ''
                    $('#address_province').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
                })

                if (userAddressProvince) $('#address_province').trigger('change')
            })

            // fetch cities on province change
            $('#address_province').change(function() {
                const provinceCode = $('#address_province option:selected').data('code')
                const provinceName = $(this).val()

                $('input[name="address_province"]').val(provinceName)
                $('#address_city').html('<option>Select City/Town/Municipality</option>')
                $('#address_barangay').html('<option>Select Street/Barangay</option>')

                if (!provinceCode) return

                $.get(`/address/cities/${provinceCode}`, function(data) {
                    $('#address_city').empty().append('<option>Select City/Town/Municipality</option>')
                    data.forEach(function(item) {
                        const selected = item.name == userAddressCity ? 'selected' : ''
                        $('#address_city').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
                    })

                    if (userAddressCity) $('#address_city').trigger('change')
                })
            })

            // fetch barangays on city change
            $('#address_city').change(function() {
                const cityCode = $('#address_city option:selected').data('code')
                const cityName = $(this).val()

                $('input[name="address_city"]').val(cityName)
                $('#address_barangay').html('<option>Select Street/Barangay</option>')

                if (!cityCode) return

                $.get(`/address/barangays/${cityCode}`, function(data) {
                    $('#address_barangay').empty().append('<option>Select Street/Barangay</option>')
                    data.forEach(function(item) {
                        const selected = item.name == userAddressBarangay ? 'selected' : ''
                        $('#address_barangay').append(`<option value="${item.name}" ${selected}>${item.name}</option>`)
                    })
                })
            })
        })
    </script>
@endsection
