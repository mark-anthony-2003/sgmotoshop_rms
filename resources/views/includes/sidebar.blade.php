@if (auth()->check() && auth()->user()->user_type === 'admin')
    <aside>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('admin-panel') }}">Dashboard</a>
                </li>

                <li>Inventory Management</li>
                <li>
                    <a href="{{ route('items-table') }}">Items</a>
                </li>

                <li>Service Management</li>
                <li>
                    <a href="{{ route('serviceTypes-table') }}">Service Types</a>
                </li>
                <li>
                    <a href="{{ route('parts-table') }}">Parts</a>
                </li>

                <li>User Management</li>
                <li>
                    <a href="{{ route('employees-table') }}">Employees</a>
                </li>
                <li>
                    <a href="{{ route('customers-table') }}">Customers</a>
                </li>
            </ul>
        </nav> 
    </aside>
@endif