<div>
    <div x-show="modalOpen" class="fixed z-[60] inset-0 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div x-show="modalOpen"
            class="relative bg-cine-neutral/90 rounded-lg overflow-hidden shadow-xl max-w-screen-xl w-full m-4 max-h-screen"
            x-transition:enter="transition ease-out duration-300 transform opacity-0 scale-95"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform opacity-100 scale-100"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="px-4 py-3 sm:px-6 flex align-items justify-end p-4 gap-4 flex-row">
                <button class="justify-self-end" wire:click="$dispatch('shop-select-movie')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-white stroke-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @if ($cinema_mode)
                <div class="p-8 sm:pt-8 pt-4 overflow-y-auto text-white flex flex-wrap justify-center items-center md:gap-6 gap-3"
                    style="max-height: 70vh; border-radius: 0.375rem; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">
                    <div class="flex flex-col gap-3">
                        <h3 class="text-sm font-semibold">{{ __('distributor_frontend.name') }}</h3>
                        <div class="flex flex-wrap gap-x-2 items-center">
                            <input type="text" class="input input-bordered input-xs text-neutral"
                                placeholder="{{ __('distributor_frontend.enter_cinema_name') }}"
                                wire:model='cinemaName' />
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h3 class="text-sm font-semibold">{{ __('distributor_frontend.city') }}</h3>
                        <div class="flex flex-wrap gap-x-2 items-center">
                            <input type="text" class="input input-bordered input-xs text-neutral"
                                placeholder="{{ __('distributor_frontend.enter_city_name') }}" wire:model='cityName' />
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h3 class="text-sm font-semibold">{{ __('distributor_frontend.country') }}</h3>
                        <div class="flex flex-wrap gap-x-2 items-center">
                            <select class="select select-xs text-neutral" wire:model='country'>
                                <option selected>{{ __('distributor_frontend.please_select_a_country') }}</option>
                                @foreach ($countries as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="basis-full h-0"></div>

                    <div class="flex flex-col gap-3">
                        <h3 class="text-sm font-semibold self-center">{{ __('distributor_frontend.emails') }}</h3>
                        <div class="flex flex-wrap gap-2 justify-center">
                            @foreach ($emails as $key => $item)
                                <div class="badge gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        class="inline-block h-4 w-4 stroke-current"
                                        wire:click='remove_email({{ $key }})'>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ $item }}
                                </div>
                            @endforeach
                        </div>
                        <div class="flex flex-wrap gap-x-2 items-center self-center">
                            <input type="text" class="input input-bordered input-xs text-neutral"
                                placeholder="{{ __('distributor_frontend.enter_email') }}" wire:model='email' />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-pointer"
                                viewBox="0 0 1000 1000" fill="currentColor" wire:click='add_emails'>
                                <metadata>IcoFont Icons</metadata>
                                <title>plus</title>
                                <glyph glyph-name="plus" unicode="&#xefc2;" horiz-adv-x="1000" />
                                <path
                                    d="M935.4 459.6c-1-14.100000000000023-3.1000000000000227-29.200000000000045-6.7999999999999545-45.30000000000001h-343v-343c-16.100000000000023-3.6000000000000085-30.700000000000045-5.700000000000017-43.80000000000007-6.800000000000011-12.5-1.6000000000000014-25.5-2.1000000000000014-38.49999999999994-2.1000000000000014-15.100000000000023 0-29.69999999999999 0.5-43.69999999999999 2.1000000000000014-14.100000000000023 1-29.200000000000045 3.0999999999999943-45.30000000000001 6.799999999999997v343h-343c-3.6000000000000085 16.099999999999966-6.300000000000011 30.69999999999999-7.300000000000011 43.69999999999999-1 13-1.6000000000000014 25.5-1.6000000000000014 38.5 0 15.100000000000023 0.5 29.700000000000045 1.6000000000000014 43.700000000000045 1 14.099999999999909 3.5999999999999943 29.199999999999932 7.299999999999997 45.299999999999955h343v343c16.099999999999966 3.6000000000000227 30.69999999999999 6.2999999999999545 43.69999999999999 7.2999999999999545 13 1 25.5 1.6000000000000227 38.5 1.6000000000000227 15.100000000000023 0 29.700000000000045-0.5 43.700000000000045-1.6000000000000227 14.099999999999909-1 29.199999999999932-3.599999999999909 45.299999999999955-7.2999999999999545v-343h343c3.6000000000000227-16.100000000000023 5.7000000000000455-30.700000000000045 6.7999999999999545-43.799999999999955 1.6000000000000227-12.5 2.1000000000000227-25.5 2.1000000000000227-38.50000000000006 0.10000000000002274-14.899999999999977-0.39999999999997726-29.5-2-43.599999999999966z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 sm:px-6 flex align-items justify-end p-4 gap-4 flex-row">
                    <button type="button" wire:click='toggle_cinema_mode'
                        class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40">
                        {{ __('distributor_frontend.cancel') }} </button>
                    <button type="button"
                        class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40"
                        wire:click='add_cinema'>
                        {{ __('distributor_frontend.add_cinema') }} </button>
                </div>
            @endif

            @if (!$cinema_mode)
                <div class="p-8 sm:pt-8 pt-4 overflow-y-auto text-white grid md:grid-cols-4 md:gap-6"
                    style="max-height: 70vh; border-radius: 0.375rem; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">

                    <div class="col-span-1 hidden sm:block">
                        <figure>
                            <img src="{{ Storage::disk('public')->exists($movie['poster_image']) ? Storage::disk('public')->url($movie['poster_image']) : $movie['poster_image'] }}"
                                class="md:w-full max-w-60" alt="{{ $movie['name'] }}" />
                        </figure>
                    </div>
                    <div class="col-span-3 grid grid-flow-rows gap-y-5">
                        <h2 class="text-2xl font-bold">{{ $movie['name'] }}</h2>
                        <div class="flex flex-wrap gap-x-3 items-center">
                            <h3 class="text-sm font-semibold">{{ __('distributor_frontend.version') }}</h3>
                            <select class="select select-bordered select-xs w-full max-w-40 text-black"
                                wire:model='selected_version'>
                                @foreach ($movie['versions'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['version_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <livewire:components.calendar />
                        <div class="flex flex-wrap gap-x-3 items-center">
                            <h3 class="text-sm font-semibold">{{ __('distributor_frontend.cinema') }}</h3>
                            <div class="flex flex-wrap gap-x-2 items-center">
                                <input type="text" class="input input-bordered input-xs text-neutral"
                                    placeholder="{{ __('distributor_frontend.enter_cinema_city_or_group') }}"
                                    wire:model.live.debounce.250ms="search_query" />
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="w-6 h-6 cursor-pointer">
                                    <path fill-rule="evenodd"
                                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <button class="text-3xl" wire:click='toggle_cinema_mode'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 1000 1000"
                                    fill="currentColor">
                                    <metadata>IcoFont Icons</metadata>
                                    <title>plus</title>
                                    <glyph glyph-name="plus" unicode="&#xefc2;" horiz-adv-x="1000" />
                                    <path
                                        d="M935.4 459.6c-1-14.100000000000023-3.1000000000000227-29.200000000000045-6.7999999999999545-45.30000000000001h-343v-343c-16.100000000000023-3.6000000000000085-30.700000000000045-5.700000000000017-43.80000000000007-6.800000000000011-12.5-1.6000000000000014-25.5-2.1000000000000014-38.49999999999994-2.1000000000000014-15.100000000000023 0-29.69999999999999 0.5-43.69999999999999 2.1000000000000014-14.100000000000023 1-29.200000000000045 3.0999999999999943-45.30000000000001 6.799999999999997v343h-343c-3.6000000000000085 16.099999999999966-6.300000000000011 30.69999999999999-7.300000000000011 43.69999999999999-1 13-1.6000000000000014 25.5-1.6000000000000014 38.5 0 15.100000000000023 0.5 29.700000000000045 1.6000000000000014 43.700000000000045 1 14.099999999999909 3.5999999999999943 29.199999999999932 7.299999999999997 45.299999999999955h343v343c16.099999999999966 3.6000000000000227 30.69999999999999 6.2999999999999545 43.69999999999999 7.2999999999999545 13 1 25.5 1.6000000000000227 38.5 1.6000000000000227 15.100000000000023 0 29.700000000000045-0.5 43.700000000000045-1.6000000000000227 14.099999999999909-1 29.199999999999932-3.599999999999909 45.299999999999955-7.2999999999999545v-343h343c3.6000000000000227-16.100000000000023 5.7000000000000455-30.700000000000045 6.7999999999999545-43.799999999999955 1.6000000000000227-12.5 2.1000000000000227-25.5 2.1000000000000227-38.50000000000006 0.10000000000002274-14.899999999999977-0.39999999999997726-29.5-2-43.599999999999966z" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            @if (!empty($search_query))
                                <h3 class="text-sm font-semibold">
                                    @if ($cinemaGroups->count() > 0)
                                        {{ $cinemaGroups->count() }} {{ __('distributor_frontend.groups_found') }}
                                    @else
                                        {{ __('distributor_frontend.no_groups_found') }}
                                    @endif
                                    @if ($cinemas->count() > 0)
                                        {{ $cinemas->count() }} {{ __('distributor_frontend.cinemas_found') }}
                                    @else
                                        {{ __('distributor_frontend.no_cinemas_found') }}
                                    @endif
                                </h3>
                            @endif
                        </div>

                        {{-- Mobile Menu --}}
                        <div
                            class="border-gray-500 p-2 overflow-y-scroll border rounded max-h-60 gap-y-2 overflow-x-scroll min-w-[350px] block sm:hidden">
                            @if (empty($search_query))
                                <h3 class="text-sm font-semibold">
                                    {{ __('distributor_frontend.no_cinemas_and_groups_please_start_searching') }}</h3>
                            @endif
                            @foreach ($cinemaGroups as $item)
                                <div class="px-4 ">
                                    <div class="flex justify-between items-center" x-data="{ open: false }">
                                        <div>
                                            <h4 class="text-base font-bold truncate">{{ $item->name }}</h4>
                                            <div class="flex gap-1">
                                                <h4 class="text-sm font-medium truncate">
                                                    {{ $item->cinemas()->count() }}
                                                    {{ __('distributor_frontend.cinemas') }}</h4>
                                            </div>
                                        </div>
                                        <input type="checkbox" value="{{ $item->id }}"
                                            class="checkbox justify-self-end border-white/50 border h-6"
                                            wire:click="updateSelectedNames({{ $item->id }}, '{{ $item->name }}', '{{ $item?->city_name }}', 'group')"
                                            wire:model.live="selectedCinemaGroups"
                                            wire:key="group-{{ $item->id }}" />
                                    </div>
                                    <div
                                        class="divider before:bg-white after:bg-white m-0 before:h-[1px] after:h-[1px]">
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($cinemas as $item)
                                <div class="px-4 ">
                                    <div class="flex justify-between items-center" x-data="{ open: false }">
                                        <div>
                                            <h4 class="text-base font-bold truncate">{{ $item->name }}</h4>
                                            <div class="flex gap-1">
                                                <h4 class="text-sm font-medium truncate">
                                                    {{ __('distributor_frontend.city') }}
                                                </h4>
                                                <h4 class="text-sm font-semibold truncate">{{ $item->city_name }}</h4>
                                            </div>
                                            <div class="flex gap-1">
                                                <h4 class="text-sm font-medium truncate">
                                                    {{ __('distributor_frontend.country') }}
                                                </h4>
                                                <h4 class="text-sm font-semibold truncate">{{ $item->country->name }}
                                                </h4>
                                            </div>
                                        </div>
                                        <input type="checkbox" value="{{ $item->id }}"
                                            class="checkbox justify-self-end border-white/50 border h-6"
                                            wire:click="updateSelectedNames({{ $item->id }}, '{{ $item->name }}', '{{ $item?->city_name }}', 'cinema')"
                                            wire:model.live="selectedCinemas"
                                            wire:key="cinema-{{ $item->id }}" />
                                    </div>
                                    <div
                                        class="divider before:bg-white after:bg-white m-0 before:h-[1px] after:h-[1px]">
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- Desktop Menu --}}
                        <div
                            class="border-gray-500 p-2 overflow-y-scroll border rounded max-h-60 gap-y-2 overflow-x-scroll min-w-[350px] hidden sm:block">

                            @if (empty($search_query))
                                <h3 class="text-sm font-semibold">
                                    {{ __('distributor_frontend.no_cinemas_and_groups_please_start_searching') }}</h3>
                            @endif

                            @if ($cinemaGroups->count() > 0)
                                <div class="mb-2">
                                    <h3 class="text-sm font-semibold underline mb-3">
                                        {{ __('distributor_frontend.groups') }}</h3>

                                    <div class="flex flex-nowrap gap-2 justify-between">
                                        @foreach ($cinemaGroups as $item)
                                            <h4
                                                class="text-sm font-semibold truncate lg:max-w-80 md:max-w-40 max-w-56 flex-1 h-6">
                                                {{ $item->name }}
                                            </h4>
                                            <input type="checkbox"
                                                class="checkbox justify-self-end border-white/50 border ml-auto h-6"
                                                value="{{ $item->id }}"
                                                wire:click="updateSelectedNamesForGroups({{ $item->id }})"
                                                wire:model.live="selectedCinemaGroups"
                                                wire:key="group-{{ $item->id }}" />
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                            @if ($cinemas->count() > 0)
                                <h3 class="text-sm font-semibold underline mb-3">
                                    {{ __('distributor_frontend.cinemas') }}</h3>
                                <div class="flex flex-nowrap gap-2 justify-between">
                                    <div class="flex flex-col gap-2">
                                        @foreach ($cinemas as $item)
                                            <h4
                                                class="text-sm font-semibold truncate lg:max-w-80 md:max-w-40 max-w-56 flex-1 h-6">
                                                {{ $item->name }}
                                            </h4>
                                        @endforeach
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        @foreach ($cinemas as $item)
                                            <h4 class="text-sm font-semibold truncate lg:max-w-48 max-w-56 flex-1 h-6">
                                                {{ $item->city_name }}
                                            </h4>
                                        @endforeach
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        @foreach ($cinemas as $item)
                                            <h4
                                                class="text-sm font-semibold truncate xl:max-w-64 max-w-40 lg:max-w-28 h-6">
                                                {{ $item->country->name }}
                                            </h4>
                                        @endforeach
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        @foreach ($cinemas as $item)
                                            <input type="checkbox"
                                                class="checkbox justify-self-end border-white/50 border ml-auto h-6"
                                                value="{{ $item->id }}"
                                                wire:click="updateSelectedNames({{ $item->id }}, '{{ $item->name }}', '{{ $item?->city_name }}', 'cinema')"
                                                wire:model.live="selectedCinemas"
                                                wire:key="cinema-{{ $item->id }}" />
                                        @endforeach
                                    </div>

                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap sm:hidden gap-[5px]">
                            @foreach ($selectedNames ?? [] as $item)
                                <div class="flex items-center gap-[3px]">
                                    <h4 class="text-sm font-semibold text-white">{{ $item['name'] }}@if (array_key_exists('city_name', $item))
                                            {{ $item['city_name'] }}
                                        @endif
                                        @if (array_key_exists('cinema_names', $item))
                                            ({{ $item['cinema_names'] }})
                                        @endif
                                    </h4>
                                    @if (array_key_exists('group_id', $item))
                                        <button
                                            class="btn btn-circle btn-outline border-white w-[10px] min-h-[10px] max-h-[10px]"
                                            wire:click="removeSelectedNameForGroup({{ $item['id'] }}, {{ $item['group_id'] }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 stroke-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-circle btn-outline border-white w-[10px] min-h-[10px] max-h-[10px]"
                                            wire:click="removeSelectedName({{ $item['id'] }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 stroke-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 sm:px-6 flex align-items justify-end p-4 gap-4 flex-col">
                    <div class="sm:flex sm:flex-wrap hidden gap-[5px]">
                        @foreach ($selectedNames ?? [] as $item)
                            <div class="flex items-center gap-[3px]">
                                <h4 class="text-sm font-semibold text-white">{{ $item['name'] }}@if (array_key_exists('city_name', $item))
                                        {{ $item['city_name'] }}
                                    @endif
                                    @if (array_key_exists('cinema_names', $item))
                                        ({{ $item['cinema_names'] }})
                                    @endif
                                </h4>
                                @if (array_key_exists('group_id', $item))
                                    <button
                                        class="btn btn-circle btn-outline border-white w-[10px] min-h-[10px] max-h-[10px]"
                                        wire:click="removeSelectedNameForGroup({{ $item['id'] }}, {{ $item['group_id'] }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 stroke-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @else
                                    <button
                                        class="btn btn-circle btn-outline border-white w-[10px] min-h-[10px] max-h-[10px]"
                                        wire:click="removeSelectedName({{ $item['id'] }}, '{{ $item['type'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 stroke-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif

                            </div>
                        @endforeach
                    </div>

                    <form wire:submit="makeOrder"
                        class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40">
                        <button type="submit"
                            class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40">
                            {{ __('distributor_frontend.confirm_order') }} </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
