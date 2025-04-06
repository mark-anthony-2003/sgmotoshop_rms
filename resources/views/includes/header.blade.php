<nav>
    <div>
        <a href="{{ route('home') }}">SG</a>
    </div>
    <ul>
        @if (Auth::check())
            @if (Auth::user()->user_type === 'customer')
                <li>
                    Cart @if ($cartCount > 0) {{ $cartCount }} @endif
                </li>
                <li>
                    <a href="{{ route('customer-profile', ['customerId' => auth()->user()->user_id]) }}">
                        {{ strtoupper(auth()->user()->user_first_name[0]) }} {{ strtoupper(auth()->user()->user_last_name[0]) }}
                    </a>
                </li>
            @endif
            <li>
                <form action="{{ route('sign-out') }}" method="POST">
                    @csrf
                    <button type="submit">Sign out</button>
                </form>
            </li>
        @else
            <li>
                <a href="{{ route('sign-in') }}">Sign in</a>
            </li>
        @endif
    </ul>
</nav>