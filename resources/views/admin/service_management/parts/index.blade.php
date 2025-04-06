@extends('includes.app')

@section('content')
    <h2>Parts Table</h2>

    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No#</th>
                <th>Part Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($partsList as $index => $part)
                <tr>
                    <td> {{ $index + 1 }} </td>
                    <td> {{ $part->part_name }} </td>
                    <td>
                        
                        <form action="{{ route('part-delete', $part) }}" method="post">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No Services Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

