@extends('includes.app')

@section('content')
    <section class="flex justify-center items-center mt-18">
        <div class="w-full max-w-md px-4 py-4 sm:px-4">
            <h2 class="text-2xl font-bold text-center text-[#222831] mb-5">Sign up as Customer</h2>
    
            <form action="{{ route('sign-up.customer.submit') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="user_type" value="{{ $userType ?? 'customer' }}">
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-[#30475E]">First Name</label>
                        <input 
                            type="text" name="first_name" id="first_name" 
                            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-[#30475E]">Last Name</label>
                        <input 
                            type="text" name="last_name" id="last_name" 
                            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md" required>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-[#30475E]">Email</label>
                    <input 
                        type="email" name="email" id="email" 
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-[#30475E]">Password</label>
                    <input 
                        type="password" name="password" id="password" 
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md" required>
                </div>
                <div class="flex items-center justify-end">
                    <input 
                        type="checkbox" 
                        id="show_password" 
                        class="h-4 w-4 text-[#30475E] border-gray-300 rounded"
                        onclick="togglePasswordVisibility()"
                    >
                    <label for="show_password" class="ml-2 text-sm text-gray-700">
                        Show Password
                    </label>
                </div>
    
                <div>
                    <button 
                        type="submit" 
                        class="w-full py-2 px-4 bg-[#30475E] text-white text-sm font-medium rounded-md transition duration-150"
                    > Sign Up
                    </button>
                </div>
    
                <div class="text-center">
                    <p class="text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('sign-in.customer') }}" class="text-[#30475E] hover:underline">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const togglePasswordVisibility = () => {
        const password = document.getElementById('password');
        const type = document.getElementById('show_password').checked ? 'text' : 'password';
        password.type = type;
    }
</script>
@endpush

