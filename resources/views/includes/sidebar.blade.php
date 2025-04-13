@php
    $activeClass = 'bg-gray-200 font-semibold text-gray-900';
@endphp

@if (auth()->check() && auth()->user()->user_type === 'admin')
<aside class="w-64 bg-white border-r border-gray-200 h-screen sticky top-0 mt-18">
    <nav class="p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Admin Navigation</h2>
        <ul class="space-y-2 text-sm text-gray-600">
            <li>
                <a href="{{ route('admin-panel') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 {{ Route::is('admin-panel') ? $activeClass : '' }}">
                   Dashboard
                </a>
            </li>

            <li class="mt-4 font-semibold text-gray-500 uppercase">Inventory Management</li>
            <li>
                <a href="{{ route('items-table') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 {{ Route::is('items-table') ? $activeClass : '' }}">
                   Items
                </a>
            </li>

            <li class="mt-4 font-semibold text-gray-500 uppercase">Service Management</li>
            <li>
                <a href="{{ route('serviceTypes-table') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 {{ Route::is('serviceTypes-table') ? $activeClass : '' }}">
                   Service Types
                </a>
            </li>
            <li>
                <a href="{{ route('parts-table') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 {{ Route::is('parts-table') ? $activeClass : '' }}">
                   Parts
                </a>
            </li>

            <li class="mt-4 font-semibold text-gray-500 uppercase">User Management</li>
            <li>
                <a href="{{ route('employees-table') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 {{ Route::is('employees-table') ? $activeClass : '' }}">
                   Employees
                </a>
            </li>
            <li>
                <a href="{{ route('customers-table') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 {{ Route::is('customers-table') ? $activeClass : '' }}">
                   Customers
                </a>
            </li>
        </ul>
    </nav>
</aside>
@endif
