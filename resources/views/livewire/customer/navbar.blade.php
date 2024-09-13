<div class="bg-cine-neutral text-neutral-content" data-theme="dark">
    <div class="hidden sm:block">
        <div class="container mx-auto navbar">
            <div class="navbar-start">
                <ul class="menu menu-horizontal px-1">
                    @if (Auth('customer')->check())
                        <li><a href="{{ route('customer.shop') }}"
                                class="{{ request()->is('customer/order') ? 'active' : '' }}">{{ __('distributor_frontend.order') }}</a>
                        </li>
                        <li><a href="{{ route('customer.order.history') }}"
                                class="{{ request()->is('customer/order/history') ? 'active' : '' }}">{{ __('distributor_frontend.order_history') }}</a>
                        </li>
                    @endif

                </ul>
            </div>
            <div class="navbar-center">
                <a href="{{ url('/') }}"><img src="{{ asset('cinecode_logo.png') }}" alt=""
                        class="w-32" /></a>
            </div>
            <div class="navbar-end">
                <ul class="menu menu-horizontal px-1">
                    @if (Auth('customer')->check())
                        <li x-data="{ settingsOpen: false, modelOpen: $wire.entangle('modelOpen') }" @mouseenter="settingsOpen = true"
                            @mouseleave="settingsOpen = false">
                            <details class="z-50" :open="settingsOpen">
                                <summary :open="settingsOpen">{{ __('distributor_frontend.settings') }}</summary>
                                <ul class="min-w-52 !mt-0" x-show="settingsOpen"
                                    x-transition:enter="transition ease-out duration-200 transform"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-out duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                                    <li><a href="{{ route('customer.settings') }}"
                                            class="{{ request()->is('customer/settings') ? 'active' : '' }}">{{ __('distributor_frontend.settings') }}</a>
                                    </li>
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
                                            {{ __('distributor_frontend.create_cinema_group') }}
                                        </button>
                                    </li>
                                </ul>
                            </details>
                            <livewire:customer.cinema-group-modal />
                        </li>
                        <li wire:click='doLogout'><a>{{ __('distributor_frontend.logout') }}</a></li>
                    @endif
                </ul>
                <div title="Change Language" class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost" aria-label="Language"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd"
                                d="M11 5a.75.75 0 0 1 .688.452l3.25 7.5a.75.75 0 1 1-1.376.596L12.89 12H9.109l-.67 1.548a.75.75 0 1 1-1.377-.596l3.25-7.5A.75.75 0 0 1 11 5Zm-1.24 5.5h2.48L11 7.636 9.76 10.5ZM5 1a.75.75 0 0 1 .75.75v1.261a25.27 25.27 0 0 1 2.598.211.75.75 0 1 1-.2 1.487c-.22-.03-.44-.056-.662-.08A12.939 12.939 0 0 1 5.92 8.058c.237.304.488.595.752.873a.75.75 0 0 1-1.086 1.035A13.075 13.075 0 0 1 5 9.307a13.068 13.068 0 0 1-2.841 2.546.75.75 0 0 1-.827-1.252A11.566 11.566 0 0 0 4.08 8.057a12.991 12.991 0 0 1-.554-.938.75.75 0 1 1 1.323-.707c.049.09.099.181.15.271.388-.68.708-1.405.952-2.164a23.941 23.941 0 0 0-4.1.19.75.75 0 0 1-.2-1.487c.853-.114 1.72-.185 2.598-.211V1.75A.75.75 0 0 1 5 1Z"
                                clip-rule="evenodd"></path>
                        </svg> <svg width="12px" height="12px"
                            class="hidden h-2 w-2 fill-current opacity-60 sm:inline-block"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2048">
                            <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
                        </svg></div>
                    @php
                        $conf_locales = config('translation-manager.available_locales');
                    @endphp
                    <div tabindex="0"
                        class="dropdown-content bg-base-200 text-base-content rounded-box top-px mt-16 max-h-[calc(100vh-10rem)] w-56 overflow-y-auto border border-white/5 shadow-2xl outline outline-1 outline-black/5 z-[200]">
                        <ul class="menu menu-sm gap-1 z-[200]">
                            @foreach ($conf_locales as $conf_locale)
                                <li>
                                    <button wire:click="setNavbarLocale('{{ $conf_locale['code'] }}')"
                                        class="{{ App::isLocale($conf_locale['code']) ? 'active' : '' }}">
                                        <span
                                            class="badge badge-sm badge-outline !pl-1.5 !pr-1 pt-px font-mono !text-[.6rem] font-bold tracking-widest opacity-50">
                                            {{ $conf_locale['code'] }}</span>
                                        <span class="font-[sans-serif]">{{ $conf_locale['name'] }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
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
                        @if (Auth('customer')->check())
                            <li><a href="{{ route('customer.shop') }}"
                                    class="{{ request()->is('customer/order') ? 'active' : '' }}">{{ __('distributor_frontend.order') }}</a>
                            </li>
                            <li><a href="{{ route('customer.order.history') }}"
                                    class="{{ request()->is('customer/order/history') ? 'active' : '' }}">{{ __('distributor_frontend.order_history') }}</a>
                            </li>
                            <li><a href="{{ route('customer.settings') }}"
                                    class="{{ request()->is('customer/settings') ? 'active' : '' }}">{{ __('distributor_frontend.settings') }}</a>
                            </li>
                            <li wire:click='doLogout'><a>{{ __('distributor_frontend.logout') }}</a></li>
                        @endif
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
