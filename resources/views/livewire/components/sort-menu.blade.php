<div>
    @php
        $sort_index = array_search($sort, array_column($sort_array, 'value'));
    @endphp
    <div class="dropdown" x-data="{ openSort: false }">
        <div tabindex="0" role="button" class="btn sm:text-sm text-xs" @click.away="openSort = false"
            @click="openSort = !openSort">
            Sort: {{ $sort_array[$sort_index]['name'] }}
            <svg width="12px" height="12px" class="h-2 w-2 fill-current opacity-60 inline-block"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2048">
                <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
            </svg>
        </div>
        <ul tabindex="0" class="dropdown-content z-[1] p-2 shadow-2xl bg-base-300 rounded-box w-52 absolute right-0"
            x-show="openSort" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95">
            @foreach ($sort_array as $item)
                <li>
                    <input type="radio" name="theme-dropdown"
                        class="theme-controller btn btn-sm btn-block btn-ghost justify-start checked:!bg-cine-highlight-1 checked:!text-inherit checked:!border-cine-highlight-1"
                        aria-label="{{ $item['name'] }}" value="{{ $item['value'] }}" wire:model="sort"
                        wire:click="updateSort('{{ $item['value'] }}')" />
                </li>
            @endforeach
        </ul>
    </div>
    {{-- <div @click.away="openSort = false" class="relative justify-self-end" x-data="{ openSort: false, sortType: 'Release Date' }">
        <button @click="openSort = !openSort"
            class="flex text-base-content items-center w-40 py-2 justify-end text-base font-semibold text-left bg-transparent rounded-lg ">
            <span x-text="sortType" class="pr-1"></span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{ 'rotate-180': openSort, 'rotate-0': !openSort }"
                class="w-4 h-4  transition-transform duration-200 transform ">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <div x-show="openSort" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 w-full  origin-top-right">
            <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg dark:bg-cine-highlight-1 dark:text-neutral-content"
                data-theme="dark">
                <div class="flex flex-col">
                    <a @click="sortType='Most disscussed',openSort=!openSort" x-show="sortType != 'Most disscussed'"
                        class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 hover:text-cine-highlight-1 "
                        href="#">

                        <div class="">
                            <p class="font-semibold">Most disscussed</p>
                        </div>
                    </a>

                    <a @click="sortType='Most popular',openSort=!openSort" x-show="sortType != 'Most popular'"
                        class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 hover:text-cine-highlight-1 "
                        href="#">

                        <div class="">
                            <p class="font-semibold">Most popular</p>
                        </div>
                    </a>

                    <a @click="sortType='Most upvoted',openSort=!openSort" x-show="sortType != 'Most upvoted'"
                        class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 hover:text-cine-highlight-1 "
                        href="#">

                        <div class="">
                            <p class="font-semibold">Most upvoted</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
</div>
