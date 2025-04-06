@extends('includes.app')

@section('content')
    <h2>Services Table</h2>

    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No#</th>
                <th>Service Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($serviceTypesList as $index => $serviceType)
                <tr>
                    <td> {{ $index + 1 }} </td>
                    <td> {{ $serviceType->service_type_name }} </td>
                    <td> {{ $serviceType->service_type_price }} </td>
                    <td> {{ $serviceType->service_type_status }} </td>
                    <td>
                        
                        <form action="{{ route('serviceType-delete', $serviceType) }}" method="post">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No Services Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

