<div class="bg-cine-neutral" data-theme="dark">
    <footer class="container mx-auto footer items-center p-4 text-neutral-content md:gap-y-10 gap-y-4">
        <aside class="items-center grid-flow-col md:justify-self-auto justify-self-center">
            <a><img src="{{ asset('cinecode_logo.png') }}" alt="" class="w-28" /></a>
        </aside>
        <nav class="grid-flow-col gap-4 md:place-self-center justify-self-center md:justify-self-end">
            <ul class="menu menu-horizontal px-1 md:justify-end justify-center">
                <li><a href="{{ __('footer.httpswwwcinecodedecontact') }}">{{ __('distributor_frontend.contact') }}</a>
                </li>
                <li><a
                        href="{{ __('footer.httpswwwcinecodededatenschutzerklaerung') }}">{{ __('distributor_frontend.data_protection') }}</a>
                </li>
                <li><a
                        href="{{ __('footer.httpswwwcinecodedeimpressum') }}">{{ __('distributor_frontend.imprint') }}</a>
                </li>
                <li>
                    <p>
                        <a href="{{ __('footer.copyright') }}">{{ __('distributor_frontend.copyright_') }}
                            {{ now()->format('Y') }} -
                            {{ __('distributor_frontend.all_right_reserved') }}</a>
                    </p>
                </li>
            </ul>
        </nav>
    </footer>
</div>
