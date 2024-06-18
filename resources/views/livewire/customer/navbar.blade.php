<div class="bg-cine-neutral text-neutral-content" data-theme="dark">
    <div class="hidden sm:block">
        <div class="container mx-auto navbar">
            <div class="navbar-start">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('customer.shop') }}"
                            class="{{ request()->is('customer/shop') ? 'active' : '' }}">Order</a></li>
                    <li><a href="{{ route('customer.order.history') }}"
                            class="{{ request()->is('customer/order/history') ? 'active' : '' }}">History</a></li>
                </ul>
            </div>
            <div class="navbar-center">
                <a href="{{ url('/') }}"><img src="{{ asset('cinecode_logo.png') }}" alt=""
                        class="w-32" /></a>
            </div>
            <div class="navbar-end">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('customer.settings') }}"
                            class="{{ request()->is('customer/settings') ? 'active' : '' }}">Settings</a></li>
                    <li><a>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="block sm:hidden">
        <div class="navbar">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>Order</a></li>
                        <li><a>History</a></li>
                        <li><a>Settings</a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="navbar-center">
                {{-- <a class="btn btn-ghost text-xl">daisyUI</a> --}}
            </div>
            <div class="navbar-end">
                <a><img src="{{ asset('cinecode_logo.png') }}" alt="" class="w-32" /></a>
            </div>
        </div>
    </div>

</div>
