<div>
    <div class="min-h-screen">
        <div class="prose prose-sm md:prose-base max-w-full flex-grow pt-10">
            <h1>Orders</h1>
            <div class="flex flex-wrap sm:flex-row flex-col justify-between">
                <p class="!mt-0">{{ $orders->total() }} Orders</p>

                <div class="flex flex-wrap items-center gap-4" x-data="{ filterByDownloaded: $wire.entangle('filterByDownloaded').live, filterByMovie: $wire.entangle('filterByMovie').live, filterOrderDateFrom: $wire.entangle('filterOrderDateFrom').live, filterOrderDateTo: $wire.entangle('filterOrderDateTo').live }">
                    <label class="input input-bordered flex items-center gap-2 h-10 sm:w-72 w-52">
                        <input type="text" class="grow" placeholder="Search"
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

        <x-table :headers="$headers" :rows="$orders" with-pagination>

            @scope('cell_movie.name', $order)
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
                            class="badge badge-{{ $order->downloaded ? 'primary' : 'error' }} badge-sm">{{ $order->downloaded ? 'Downloaded' : 'Not Downloaded' }}</span>
                    </div>
                </div>
            @endscope

            @scope('cell_fakeColumn', $order)
                <div>
                    <span class="text-sm font-medium">Start
                        Date: </span>{{ $order->validity_period_from->format('d.m.Y') }}
                </div>
                <div>
                    <span class="text-sm font-medium">End
                        Date:
                    </span>{{ $order->validity_period_to->format('d.m.Y') }}
                </div>
            @endscope

            @scope('cell_created_at', $order)
                {{ $order->created_at->format('d.m.Y') }}
            @endscope

            @scope('cell_downloadColumn', $order)
                @php
                    $userId = \CinemaUniqueAuth::user()->id;
                    $orderCinema = $order->order_cinemas()->where('cinema_id', $userId)->first();
                    $c = request()->c;
                    $url =
                        route('cinema.movie.download') .
                        "?token={$orderCinema?->download_token}&order={$order->id}&c={$c}";
                @endphp
                <x-button icon="o-play" wire:click="download('{{ $url }}', '{{ $order->id }}')" spinner
                    class="btn-sm" />
                <x-button icon="o-arrow-down-on-square" wire:click="downloadMcck('{{ $order->id }}')" spinner
                    class="btn-sm" />
            @endscope

        </x-table>
    </div>
</div>
