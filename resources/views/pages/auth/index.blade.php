@extends('includes.app')

@section('content')
    <section>
        <a href="{{ route('sign-in.customer') }}">Sign in as Customer</a>
        <a href="{{ route('sign-in.employee-as') }}">Sign in as Employee</a>
    </section>
@endsection
