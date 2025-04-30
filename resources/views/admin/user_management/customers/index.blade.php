@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <h2 class="text-2xl font-bold text-[#222831] mb-5">Customers Table</h2>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Customer Name</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Account Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($customers as $index => $customer)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ Str::title($customer->first_name) }} {{ Str::title($customer->last_name) }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $customer->email }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800 uppercase">{{ $customer->user_status }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-gray-800 hover:underline px-1">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="7" class="text-center">No Customers</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
