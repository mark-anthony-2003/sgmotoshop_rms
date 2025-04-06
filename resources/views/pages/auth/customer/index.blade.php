@extends('includes.app')

@section('content')
    <h2>Customer Sign in</h2>

    <form action="{{ route('sign-in.customer.submit') }}" method="post">
        @csrf
        <input type="hidden" name="user_type" value="{{ $userType ?? 'customer' }}">

        <label for="user_email">Email</label>
        <input type="email" name="user_email">

        <label for="user_password">Password</label>
        <input type="password" name="user_password">

        <button type="submit">Sign in</button>
    </form>
@endsection

