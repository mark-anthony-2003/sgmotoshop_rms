<nav>
    <div>
        <a href="{{ route('home') }}">SG</a>
    </div>
    <ul>
        @if (Auth::check())
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