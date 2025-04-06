@extends('includes.app')

@section('content')
    <h2>Home Panel</h2>

    @if (Auth::check() && Auth::user()->user_type === 'customer')
        <div>
            <a href="{{ route('items') }}">Order Items</a>
            <a href="{{ route('reservation-form') }}">Make a Reservation</a>
        </div>
    @endif
@endsection

