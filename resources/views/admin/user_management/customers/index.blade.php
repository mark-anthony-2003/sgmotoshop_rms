@extends('includes.app')

@section('content')
    <h2>Customers Table</h2>

    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No#</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Account Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $index => $customer)
                <tr>
                    <td> {{ $index + 1 }} </td>
                    <td> {{ $customer->user_first_name }} {{ $customer->user_last_name }} </td>
                    <td> {{ $customer->user_email }} </td>
                    <td> {{ $customer->user_type }} </td>
                    <td> {{ $customer->user_account_status }} </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No Customers</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

