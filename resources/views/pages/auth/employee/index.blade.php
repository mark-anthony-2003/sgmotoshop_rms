@extends('includes.app')

@section('content')
    <h2>Employee Sign in As</h2>
    <a href="{{ route('sign-in.employee-as-manager') }}">Manager</a>
    <a href="{{ route('sign-in.employee-as-laborer') }}">Laborer</a>
@endsection
