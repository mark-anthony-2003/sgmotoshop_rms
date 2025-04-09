@extends('includes.app')

@section('content')
    <h2>Employees Table</h2>

    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No#</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>User Type</th>
                <th>Account Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $index => $employee)
                <tr>
                    <td> {{ $index + 1 }} </td>
                    <td> {{ $employee->user->user_first_name }} {{ $employee->user->user_last_name }} </td>
                    <td> {{ $employee->user->user_email }} </td>
                    <td> {{ $employee->positionType->position_type_name }} </td>
                    <td>
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-500 text-white">
                            {{ $employee->user->user_type }}
                        </span>
                    </td>

                    <td> {{ $employee->user->user_account_status }} </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No Employees</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

