@extends('includes.app')

@section('content')
    <h2>Reservation</h2>

    <form action="{{ route('reservation.submit') }}" method="post">
        @csrf

        <div>
            <h4>Customer's Information</h4>

            <div>
                <label for="user_first_name">First Name</label>
                <input type="text" name="user_first_name" value="{{ old('user_first_name', $customer->user_first_name) }}" disabled>

                <label for="user_last_name">Last Name</label>
                <input type="text" name="user_last_name" value="{{ old('user_last_name', $customer->user_last_name) }}" disabled>
            </div>
            <div>
                <h4>Address</h4>

                <div>
                    <label for="address_barangay">Barangay</label>
                    <input type="text" name="address_barangay" value="{{ old('address_barangay', $address->first()->address_barangay ?? '') }}" disabled>

                    <label for="address_city">City</label>
                    <input type="text" name="address_city" value="{{ old('address_city', $address->first()->address_city ?? '') }}" disabled>

                    <label for="address_province">Province</label>
                    <input type="text" name="address_province" value="{{ old('address_province', $address->first()->address_province ?? '') }}" disabled>

                    <label for="address_country">Country</label>
                    <input type="text" name="address_country" value="{{ old('address_country', $address->first()->address_country ?? '') }}" disabled>
                </div>
            </div>
            <div>
                <h4>Contact Information</h4>

                <div>
                    <label for="user_contact_no">Contact No</label>
                    <input type="text" name="user_contact_no" value="{{ old('user_contact_no', $customer->user_contact_no) }}" disabled>

                    <label for="user_email">Email Address (optional)</label>
                    <input type="email" name="user_email">
                </div>
            </div>
        </div>

        <div>
            <h4>Available Services</h4>

            <table>
                <thead>
                    <tr>
                        <th>Service Offered</th>
                        <th>Cost/Price</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($serviceTypes as $serviceType)
                        <tr>
                            <td> {{ $serviceType->service_type_name }} </td>
                            <td> ₱{{ $serviceType->service_type_price }} </td>
                            <td>
                                <input
                                    type="checkbox"
                                    class="service_checkbox"
                                    data-price="{{ $serviceType->service_type_price }}"
                                    data-name="{{ $serviceType->service_type_name }}"
                                    value="{{ $serviceType->service_type_id }}"
                                    name="serviceTypes[]">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No Services Available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div>
                <h4>Selected Services</h4>
                <ul id="selected_services"></ul>
                <h4>
                    Total <span id="total_price">0.00</span>
                </h4>
            </div>
        </div>

        <div>
            <h4>Transaction Date</h4>

            <label for="service_preferred_date">Preferred Date</label>
            <input type="date" name="service_preferred_date">
        </div>

        <div>
            <h4>Payment Method</h4>

            <input type="radio" name="service_payment_method" value="cash">
            <label for="service_payment_method">Cash</label>

            <input type="radio" name="service_payment_method" value="gcash">
            <label for="service_payment_method">Gcash</label>

            <label for="service_payment_ref_no">Reference No (If Online Payment)</label>
            <input type="text" name="service_payment_ref_no">
        </div>

        <button type="submit">Submit Reservation</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".service_checkbox")
            const totalPrice = document.getElementById("total_price")
            const selectedServices = document.getElementById("selected_services")

            const updateTotal = () => {
                let total = 0
                selectedServices.innerHTML = ""

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.dataset.price)

                        let li = document.createElement("li")
                        li.textContent = checkbox.closest("tr").querySelector("td:first-child").textContent
                        li.classList.add("list-group-item")
                        selectedServices.appendChild(li)
                    }
                })
                totalPrice.textContent = `₱${total.toFixed(2)}`
            }
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateTotal)
            })
        })
    </script>
@endsection
