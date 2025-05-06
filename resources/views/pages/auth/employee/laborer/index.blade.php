@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-md px-4 py-4 sm:px-4">
            <h2 class="text-2xl font-bold text-center text-[#222831] mb-5">Sign in as Laborer</h2>

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sign-in.laborer.submit') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="employee_type" value="{{ $employeeType ?? 'laborer' }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-[#222831]">Email</label>
                    <input 
                        type="email" name="email" id="email"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md"
                        value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-[#222831]">Password</label>
                    <input 
                        type="password" name="password" id="password"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md" required>
                </div>

                <div class="flex items-center justify-end">
                    <input 
                        type="checkbox" id="show_password"
                        class="h-4 w-4 text-[#30475E] border-gray-300 rounded"
                        onclick="togglePasswordVisibility()">
                    <label for="show_password" class="ml-2 text-sm text-[#222831]">Show Password</label>
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full py-2 px-4 bg-[#30475E] text-white text-sm font-medium rounded-md transition duration-150"
                    >Sign In</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const togglePasswordVisibility = () => {
        const passwordInput = document.getElementById('password');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
