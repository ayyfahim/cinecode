<div>
    <div class="dropdown not-prose dropdown-end dropdown-bottom" x-data="{ openFilter: false }"
        :class="{ 'dropdown-open': openFilter }">
        <div class="btn btn-square btn-sm h-10 w-10" tabindex="0" role="button" @click="openFilter = !openFilter">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-base-content" viewBox="0 0 1000 1000">
                <metadata>IcoFont Icons</metadata>
                <title>filter</title>
                <glyph glyph-name="filter" unicode="&#xef29;" horiz-adv-x="1000" />
                <path
                    d="M394.8 476c9.300000000000011 9.899999999999977 14.399999999999977 23 14.399999999999977 36.39999999999998v396.20000000000005c0 23.799999999999955 29.19999999999999 36 46.400000000000034 19.199999999999932l112-126.69999999999993c15-17.800000000000068 23.299999999999955-26.5 23.299999999999955-44.10000000000002v-244.5c0-13.399999999999977 5.2000000000000455-26.399999999999977 14.399999999999977-36.39999999999998l321.4000000000001-344.20000000000005c24.09999999999991-25.799999999999983 5.5-67.69999999999997-30.100000000000023-67.69999999999997h-793.1c-35.599999999999994 0-54.2 41.8-30.099999999999994 67.7l321.4 344.1z" />
            </svg>
        </div>
        <div tabindex="0"
            class="dropdown-content z-[1] shadow-2xl bg-white rounded-box absolute mt-2 max-w-xs w-screen"
            x-show="openFilter" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95" @click.outside="openFilter = false">
            <div class="grid gap-y-4 p-6">
                <div class="flex items-center justify-between">
                    <h4 class="text-base font-semibold leading-6 text-gray-950">
                        {{ __('distributor_frontend.filters') }}
                    </h4>

                    <div>
                        <button class="group/link relative inline-flex items-center justify-center outline-none gap-1.5"
                            type="button">
                            <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                class="animate-spin fi-link-icon h-5 w-5 text-custom-600 dark:text-custom-400"
                                style="--c-400:var(--danger-400);--c-600:var(--danger-600);"
                                wire:loading.delay.default="" wire:target="resetTableFiltersForm">
                                <path clip-rule="evenodd"
                                    d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                    fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z"
                                    fill="currentColor"></path>
                            </svg>

                            <span
                                class="font-semibold group-hover/link:underline group-focus-visible/link:underline text-sm text-red-600"
                                wire:click='$parent.resetFilter()'>
                                {{ __('distributor_frontend.reset') }}
                            </span>
                        </button>

                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            class="animate-spin h-5 w-5 text-gray-400 dark:text-gray-500" wire:loading.delay.default=""
                            wire:target="tableFilters,applyTableFilters,resetTableFiltersForm">
                            <path clip-rule="evenodd"
                                d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                    <div class="col-1">
                        <div>
                            <div class="grid grid-cols-1 gap-6">
                                <div class="col-1">
                                    <div>
                                        <div class="grid gap-y-2">
                                            <div class="flex items-center justify-between gap-x-3 ">
                                                <label class="inline-flex items-center gap-x-3">
                                                    <span class="text-sm font-medium leading-6 text-gray-950">
                                                        {{ __('distributor_frontend.downloaded') }}
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="grid gap-y-2">
                                                <div class="form-control">
                                                    <select class="select select-bordered w-full max-w-xs"
                                                        x-model="filterByDownloaded">
                                                        <option value="show-all">
                                                            {{ __('distributor_frontend.show_all') }}</option>
                                                        <option value="yes">{{ __('distributor_frontend.yes') }}
                                                        </option>
                                                        <option value="no">{{ __('distributor_frontend.no') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <div>
                            <div class="grid grid-cols-1 gap-6">
                                <div class="col-1">
                                    <div>
                                        <div class="grid gap-y-2">
                                            <div class="flex items-center justify-between gap-x-3 ">
                                                <label class="inline-flex items-center gap-x-3">
                                                    <span class="text-sm font-medium leading-6 text-gray-950">
                                                        {{ __('distributor_frontend.movie') }}
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="grid gap-y-2">
                                                <div class="form-control">
                                                    <select class="select select-bordered w-full max-w-xs"
                                                        x-model="filterByMovie">
                                                        <option value="show-all">
                                                            {{ __('distributor_frontend.show_all') }}</option>
                                                        @foreach ($movies as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <div>
                            <div class="grid grid-cols-1 gap-6">
                                <div class="col-1">
                                    <div>
                                        <div class="grid gap-y-2">
                                            <div class="flex items-center justify-between gap-x-3 ">
                                                <label class="inline-flex items-center gap-x-3">
                                                    <span class="text-sm font-medium leading-6 text-gray-950">
                                                        {{ __('distributor_frontend.order_date_from') }}
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="grid gap-y-2">
                                                <label class="input input-bordered flex items-center gap-2">
                                                    <input type="date" class="grow"
                                                        x-model="filterOrderDateFrom" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <div>
                            <div class="grid grid-cols-1 gap-6">
                                <div class="col-1">
                                    <div>
                                        <div class="grid gap-y-2">
                                            <div class="flex items-center justify-between gap-x-3 ">
                                                <label class="inline-flex items-center gap-x-3">
                                                    <span class="text-sm font-medium leading-6 text-gray-950">
                                                        {{ __('distributor_frontend.order_date_to') }}
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="grid gap-y-2">
                                                <label class="input input-bordered flex items-center gap-2">
                                                    <input type="date" class="grow"
                                                        x-model="filterOrderDateTo" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
