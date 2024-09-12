<div>
    <div class="min-h-screen flex flex-wrap">
        <div class="xl:w-5/6 w-full">
            <div class="prose prose-sm md:prose-base max-w-full flex-grow pt-10">
                <h1>{{ __('distributor_frontend.order_history') }}</h1>
                <div class="flex flex-wrap sm:flex-row flex-col justify-between">
                    <p class="!mt-0">{{ $orders->total() }} Orders</p>
                    <div class="flex flex-wrap items-center gap-4" x-data="{ filterByDownloaded: $wire.entangle('filterByDownloaded').live, filterByMovie: $wire.entangle('filterByMovie').live, filterOrderDateFrom: $wire.entangle('filterOrderDateFrom').live, filterOrderDateTo: $wire.entangle('filterOrderDateTo').live }">
                        <label class="input input-bordered flex items-center gap-2 h-10 sm:w-72 w-52">
                            <input type="text" class="grow" placeholder="{{ __('distributor_frontend.search') }}"
                                wire:model.live.debounce.250ms='search_query' />
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="w-4 h-4 opacity-70">
                                <path fill-rule="evenodd"
                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                        <livewire:components.order-history-filter-menu :movies='$movies' />
                    </div>
                </div>
            </div>

            <div class="gap-5">
                <div class="not-prose">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>{{ __('distributor_frontend.movie') }}</th>
                                    <th>{{ __('distributor_frontend.versions') }}</th>
                                    <th>{{ __('distributor_frontend.cinema') }}</th>
                                    <th>{{ __('distributor_frontend.city') }}</th>
                                    <th>{{ __('distributor_frontend.order_date') }}</th>
                                    <th>{{ __('distributor_frontend.validity_period') }}</th>
                                </tr>
                                <span class="badge badge-primary badge-sm hidden">Test</span>
                                <span class="badge badge-error badge-sm hidden">Test</span>
                            </thead>
                            <tbody>

                                @if (!$orders->count())
                                    <tr>
                                        <td colspan="6">{{ __('distributor_frontend.no_items_found') }}</td>

                                    </tr>
                                @endif

                                @foreach ($orders ?? collect([]) as $order)
                                    <tr>
                                        <td class="min-w-60">
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle w-12 h-12">
                                                        <img src="{{ Storage::disk('public')->exists($order->movie->poster_image) ? Storage::disk('public')->url($order->movie->poster_image) : $order->movie->poster_image }}"
                                                            alt="Black Panther" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $order->movie->name }}</div>
                                                    <span
                                                        class="badge badge-{{ $order->downloaded ? 'primary' : 'error' }} badge-sm">{{ $order->downloaded ? __('distributor_frontend.downloaded') : __('distributor_frontend.not_downloaded') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="min-w-32">
                                            <div
                                                class="font-medium text-sm text-slate-500 font-mono dark:text-slate-400">
                                                {{ $order->version->version_name }}
                                            </div>
                                        </td>
                                        <td class="min-w-60">
                                            <div class="text-sm">
                                                @foreach ($order->cinemas as $cinema)
                                                    {{ $cinema->name }} <br />
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                @foreach ($order->cinemas as $cinema)
                                                    {{ $cinema->city_name }} <br />
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('d.m.Y') }}
                                        </td>
                                        <td class="min-w-60">
                                            <div>
                                                <span
                                                    class="text-sm font-medium">{{ __('distributor_frontend.start_date') }}
                                                </span>{{ $order->validity_period_from->format('d.m.Y') }}
                                            </div>
                                            <div>
                                                <span
                                                    class="text-sm font-medium">{{ __('distributor_frontend.end_date') }}
                                                </span>{{ $order->validity_period_to->format('d.m.Y') }}
                                            </div>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ __('distributor_frontend.movie') }}</th>
                                    <th>{{ __('distributor_frontend.versions') }}</th>
                                    <th>{{ __('distributor_frontend.cinema') }}</th>
                                    <th>{{ __('distributor_frontend.city') }}</th>
                                    <th>{{ __('distributor_frontend.order_date') }}</th>
                                    <th>{{ __('distributor_frontend.validity_period') }}</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    <div class="flex justify-center mt-4 sm:mb-0 mb-5">
                        {{ $orders->links('pagination-links-one') }}
                    </div>
                </div>
            </div>
        </div>

        <div></div>
    </div>
</div>
