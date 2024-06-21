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
                    <li x-data="{ settingsOpen: false, modelOpen: $wire.entangle('modelOpen') }" @mouseenter="settingsOpen = true" @mouseleave="settingsOpen = false">
                        <details class="z-50" :open="settingsOpen">
                            <summary :open="settingsOpen"><a href="{{ route('customer.settings') }}"
                                    class="{{ request()->is('customer/settings') ? 'active' : '' }}">Settings</a>
                            </summary>
                            <ul class="min-w-52 !mt-0" x-show="settingsOpen"
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-out duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                                <li @click="modelOpen = !modelOpen">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-neutral-content"
                                            viewBox="0 0 1000 1000" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <metadata>IcoFont Icons</metadata>
                                            <title>plus</title>
                                            <glyph glyph-name="plus" unicode="&#xefc2;" horiz-adv-x="1000" />
                                            <path
                                                d="M935.4 459.6c-1-14.100000000000023-3.1000000000000227-29.200000000000045-6.7999999999999545-45.30000000000001h-343v-343c-16.100000000000023-3.6000000000000085-30.700000000000045-5.700000000000017-43.80000000000007-6.800000000000011-12.5-1.6000000000000014-25.5-2.1000000000000014-38.49999999999994-2.1000000000000014-15.100000000000023 0-29.69999999999999 0.5-43.69999999999999 2.1000000000000014-14.100000000000023 1-29.200000000000045 3.0999999999999943-45.30000000000001 6.799999999999997v343h-343c-3.6000000000000085 16.099999999999966-6.300000000000011 30.69999999999999-7.300000000000011 43.69999999999999-1 13-1.6000000000000014 25.5-1.6000000000000014 38.5 0 15.100000000000023 0.5 29.700000000000045 1.6000000000000014 43.700000000000045 1 14.099999999999909 3.5999999999999943 29.199999999999932 7.299999999999997 45.299999999999955h343v343c16.099999999999966 3.6000000000000227 30.69999999999999 6.2999999999999545 43.69999999999999 7.2999999999999545 13 1 25.5 1.6000000000000227 38.5 1.6000000000000227 15.100000000000023 0 29.700000000000045-0.5 43.700000000000045-1.6000000000000227 14.099999999999909-1 29.199999999999932-3.599999999999909 45.299999999999955-7.2999999999999545v-343h343c3.6000000000000227-16.100000000000023 5.7000000000000455-30.700000000000045 6.7999999999999545-43.799999999999955 1.6000000000000227-12.5 2.1000000000000227-25.5 2.1000000000000227-38.50000000000006 0.10000000000002274-14.899999999999977-0.39999999999997726-29.5-2-43.599999999999966z" />
                                        </svg>
                                        Create Cinema Group
                                    </button>
                                </li>
                            </ul>
                        </details>
                        <livewire:customer.cinema-group-modal />
                    </li>
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
