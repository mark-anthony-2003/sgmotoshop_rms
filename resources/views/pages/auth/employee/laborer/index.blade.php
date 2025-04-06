@extends('includes.app')

@section('content')
    <h2>Employee Sign in As Laborer</h2>

    <form action="{{ route('sign-in.manager.submit') }}" method="post">
        @csrf
        <input type="hidden" name="employee_type" value="{{ $employeeType ?? 'laborer' }}">

        <label for="user_email">Email</label>
        <input type="email" name="user_email">

        <label for="user_password">Password</label>
        <input type="password" name="user_password">

        <button type="submit">Sign in</button>
    </form>
@endsection
