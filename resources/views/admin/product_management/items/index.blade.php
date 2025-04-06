@extends('includes.app')

@section('content')
    <h2>Items Table</h2>

    @if (session('success'))
        <div> {{ session('success') }} </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No#</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Stocks</th>
                <th>Sold</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($itemsList as $index => $item)
                <tr>
                    <td> {{ $index + 1 }} </td>
                    <td> {{ $item->item_name }} </td>
                    <td> {{ $item->item_price }} </td>
                    <td> {{ $item->item_stocks }} </td>
                    <td> {{ $item->item_sold }} </td>
                    <td> {{ $item->item_status }} </td>
                    <td>
                        
                        <form action="{{ route('item-delete', $item) }}" method="post">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No Items Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

