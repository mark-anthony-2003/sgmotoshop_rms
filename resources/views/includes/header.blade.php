<header class="fixed top-0 left-0 w-full z-50 bg-[#DDDDDD] text-[#222831] text-sm py-4">
    <nav class="max-w-[85rem] w-full mx-auto">
        <div class="flex items-center justify-between">
            <div class="flex items-center flex-shrink-0">
                @php
                    $dashboardRoute = '#';

                    if (Auth::check()) {
                        $user = Auth::user();

                        if ($user->user_type === 'customer') {
                            $dashboardRoute = route('customer.panel');
                        } elseif ($user->user_type === 'admin') {
                            $dashboardRoute = route('admin.panel');
                        } elseif ($user->user_type === 'employee') {
                            $employee = $user->employee;
                            if ($employee && $employee->positionType) {
                                if ($employee->positionType->position_name === 'manager') {
                                    $dashboardRoute = route('manager.panel');
                                } elseif ($employee->positionType->position_name === 'laborer') {
                                    $dashboardRoute = route('laborer.panel');
                                }
                            }
                        }
                    }
                @endphp
                <a 
                    href="{{ $dashboardRoute }}"
                    class="text-2xl font-semibold text-[#222831]">
                    SG
                </a>
            </div>

            <div class="hidden sm:flex flex-1 justify-center gap-x-6">
                @if (Auth::check() && Auth::user()->user_type === 'customer')
                    <a class="font-medium text-[#222831]" href="{{ route('items') }}">Items</a>
                    <a class="font-medium text-[#222831]" href="{{ route('services') }}">Services</a>
                @endif
            </div>

            <div class="flex items-center gap-x-4">
                @if (Auth::check())
                    @if (Auth::user()->user_type === 'customer')
                        <div class="hs-dropdown relative inline-flex">
                            <button id="hs-dropdown-cart" type="button" class="hs-dropdown-toggle inline-flex items-center gap-x-2 text-sm font-medium text-[#222831]">
                                Cart @if ($cartCount > 0) {{ $cartCount }} @endif
                            </button>
                            <div class="hs-dropdown-menu hidden z-50 mt-2 w-[22rem] bg-white shadow-lg rounded-lg p-4" aria-labelledby="hs-dropdown-cart">
                                <form action="{{ route('items.orderSummary.checkout') }}" method="POST">
                                    @csrf
                            
                                    <ul class="space-y-4 max-h-[400px] overflow-y-auto">
                                        @forelse ($carts as $cart)
                                            <li class="flex items-start gap-3 border-b pb-3">
                                                <input 
                                                    type="checkbox" 
                                                    name="selected_items[]" 
                                                    class="item-checkbox mt-2 accent-gray-700"
                                                    value="{{ $cart->cart_id }}"
                                                    id="cart-item-{{ $cart->cart_id }}"
                                                    data-price="{{ $cart->item->price }}"
                                                    data-id="{{ $cart->cart_id }}"
                                                >
                                                <img 
                                                    src="{{ asset('storage/' . $cart->item->image) }}" 
                                                    alt="{{ $cart->item->item_name }}" 
                                                    class="w-12 h-12 object-cover rounded-md"
                                                >
                                                <div class="flex-1">
                                                    <label for="cart-item-{{ $cart->cart_id }}" class="block font-medium text-gray-800">
                                                        {{ Str::title($cart->item->item_name) }}
                                                    </label>
                                                    <p class="text-sm text-gray-600">₱{{ number_format($cart->item->price, 2) }}</p>
                                                    <div class="flex items-center gap-1 mt-2">
                                                        <button 
                                                            type="button" 
                                                            onclick="changeCartQuantity({{ $cart->cart_id }}, -1)" 
                                                            class="px-2 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">−</button>
                                                        <input 
                                                            type="number" 
                                                            name="quantity[{{ $cart->cart_id }}]" 
                                                            id="quantity-{{ $cart->cart_id }}" 
                                                            min="1" 
                                                            max="{{ $cart->item->stocks ?? 10 }}" 
                                                            value="{{ $cart->quantity }}"
                                                            class="w-12 text-center border border-gray-300 rounded"
                                                        >
                                                        <button 
                                                            type="button" 
                                                            onclick="changeCartQuantity({{ $cart->cart_id }}, 1)" 
                                                            class="px-2 py-1 bg-gray-100 text-[#222831] rounded hover:bg-gray-200">+</button>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-center text-sm text-gray-500">Your cart is empty.</li>
                                        @endforelse
                                    </ul>
                            
                                    @if ($cartCount > 0)
                                        <div class="mt-4 border-t pt-4 space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label class="flex items-center gap-2 text-sm font-medium">
                                                    <input type="checkbox" id="selectAll" class="accent-gray-700">
                                                    Select All
                                                </label>
                                                <p class="text-sm">Total: ₱<span id="totalAmount" class="font-semibold">0.00</span></p>
                                            </div>
                            
                                            <button 
                                                type="submit" 
                                                id="checkoutButton" 
                                                class="w-full bg-[#222831] text-white py-2 px-4 rounded disabled:opacity-50"
                                                disabled
                                            >
                                                Checkout ({{ $cartCount }})
                                            </button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            
                        </div>
                    @endif

                    @php
                        $firstInitial = strtoupper(Auth::user()->first_name[0]);
                        $lastInitial = strtoupper(Auth::user()->last_name[0]);
                    @endphp
                    <div class="hs-dropdown relative inline-flex">
                        <button id="hs-dropdown-user" type="button" class="hs-dropdown-toggle inline-flex items-center gap-x-2 text-sm font-medium text-[#222831]">
                            {{ $firstInitial }}{{ $lastInitial }}
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="hs-dropdown-menu hidden z-50 mt-2 min-w-[14rem] bg-white shadow-md rounded-lg p-2" aria-labelledby="hs-dropdown-user">
                            @php
                                $user = auth()->user();
                                $userType = $user->user_type;
                                $userId = $user->user_id;
                            @endphp
                            @if ($userType === 'customer')
                                <a href="{{ route('customer.profile', ['customerId' => $userId]) }}" class="block px-4 py-2 text-sm text-[#222831]">
                                    User Settings
                                </a>
                            @elseif ($userType === 'employee')
                                @php
                                    $position = strtolower($user->employee->positionType->position_name ?? '');
                                @endphp
                                @if ($position === 'manager')
                                    <a href="{{ route('manager.profile', ['managerId' => $userId]) }}" class="block px-4 py-2 text-sm text-[#222831]">
                                        User Settings
                                    </a>
                                @elseif ($position === 'laborer')
                                    <a href="{{ route('laborer.profile', ['laborerId' => $userId]) }}" class="block px-4 py-2 text-sm text-[#222831]">
                                        User Settings
                                    </a>
                                @endif
                            @endif
                        
                            <form method="POST" action="{{ route('sign-out') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#F05454] rounded-md cursor-pointer">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('sign-in') }}"
                        class="py-2.5 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs disabled:opacity-50 disabled:pointer-events-none">
                        Sign in
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </nav>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll')
        const itemCheckboxes = document.querySelectorAll('.item-checkbox')
        const checkoutButton = document.getElementById('checkoutButton')
        const totalAmountDisplay = document.getElementById('totalAmount')
        const quantityInputs = document.querySelectorAll('.quantity-input')

        const dropdownMenu = document.querySelector('.hs-dropdown-menu')

        if (dropdownMenu) {
            dropdownMenu.addEventListener('click', function (e) {
                e.stopPropagation()
            })
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                itemCheckboxes.forEach(checkbox => checkbox.checked = this.checked)
                updateCartSummary()
            })
        }

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCartSummary)
        })

        quantityInputs.forEach(input => {
            input.addEventListener('input', updateCartSummary)
        })

        window.changeCartQuantity = function(cartId, change) {
            const quantityInput = document.getElementById(`quantity-${cartId}`)
            if (!quantityInput) return

            let value = parseInt(quantityInput.value) || 1
            const min = parseInt(quantityInput.min) || 1
            const max = parseInt(quantityInput.max) || 999

            const newValue = value + change
            if (newValue >= min && newValue <= max) {
                quantityInput.value = newValue
                updateCartSummary()
            }
        }

        function updateCartSummary() {
            let total = 0
            let checkedAny = false

            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const price = parseFloat(checkbox.getAttribute('data-price')) || 0
                    const cartId = checkbox.getAttribute('data-id')
                    const quantityInput = document.getElementById(`quantity-${cartId}`)
                    const quantity = parseInt(quantityInput?.value) || 1

                    total += price * quantity
                    checkedAny = true
                }
            })

            totalAmountDisplay.textContent = total.toFixed(2)
            if (checkoutButton) checkoutButton.disabled = !checkedAny

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = itemCheckboxes.length > 0 && [...itemCheckboxes].every(cb => cb.checked)
            }
        }

        updateCartSummary()
    })
</script>
@endpush

