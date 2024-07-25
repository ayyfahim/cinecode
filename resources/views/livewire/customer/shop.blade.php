<div>
    <div class="mb-6">
        <div class="grid sm:grid-cols-3 grid-cols-2 gap-3">
            <div class="sm:col-span-2 flex gap-4">
                <label class="input input-bordered flex items-center gap-2 h-12 sm:w-72 w-full">
                    <input type="text" class="grow" placeholder="Search"
                        wire:model.live.debounce.250ms='search_query' />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path fill-rule="evenodd"
                            d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </label>
            </div>
            <div class=" justify-self-end">
                <livewire:components.sort-menu :sort_array="$sort_array" :sort="$sort" />
            </div>
        </div>
        <h6 class="mt-3 text-opacity-50" style="opacity: 0.5;">Total Pages: {{ $movies->total() }}</h6>
    </div>

    <div class="grid gap-4 xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3 grid-cols-2 min-h-screen"
        x-data="{ modalOpen: $wire.entangle('modalOpen') }">
        @foreach ($movies as $movie)
            <livewire:customer.shop-card :key="$movie->id" :movie="$movie" />
        @endforeach
        @if ($movies->count() == 0)
            <h4>Sorry no movies exist.</h4>
        @endif
        <livewire:customer.shop-card-modal />
    </div>
    <div class="flex justify-center mt-6">
        {{ $movies->links('pagination-links-one') }}
    </div>
</div>
