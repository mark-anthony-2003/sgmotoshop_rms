@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-6xl px-4 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#222831] mb-5">Employees Table</h2>
                <a href="{{ route('employee.create.form') }}" class="inline-block px-6 py-2 bg-[#222831] text-white text-sm rounded transition">
                    Add New Employee
                </a>
            </div>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No#</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Employee Name</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Role</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Employment Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Account Status</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($employees as $index => $employee)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ Str::title($employee->user->first_name) }} {{ Str::title($employee->user->last_name) }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ $employee->user->email }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-xs font-medium text-gray-800 uppercase">{{ $employee->positionType->position_name }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap font-medium text-gray-800">
                                                <span class="inline-flex items-center gap-x-1 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                                    {{ $employee->employment_status === 'active' ? 'bg-teal-500' : 'bg-red-500' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $employee->employment_status))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrapfont-medium text-gray-800">
                                                <span class="inline-flex items-center gap-x-1 py-1.5 px-3 rounded-full text-xs font-medium text-white uppercase
                                                    {{ $employee->user->user_status === 'active' ? 'bg-teal-500' : 'bg-red-500' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $employee->user->user_status))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('employee.edit', $employee) }}" class="text-gray-800 hover:underline px-1">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="7" class="text-center">No Employees</td>
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
