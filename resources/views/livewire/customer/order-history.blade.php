<div>
    <div class="min:h-screen flex flex-wrap">
        <div class="xl:w-4/6 lg:w-7/12 w-full">
            <div class="prose prose-sm md:prose-base max-w-full flex-grow pt-10">
                <h1>Order History</h1>
                <div class="flex flex-wrap sm:flex-row flex-col justify-between">
                    <p class="!mt-0">15 Orders</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <label class="input input-bordered flex items-center gap-2 h-10 sm:w-72 w-52">
                            <input type="text" class="grow" placeholder="Search" />
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="w-4 h-4 opacity-70">
                                <path fill-rule="evenodd"
                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                        <livewire:components.order-history-filter-menu>
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
                                    <th>Name</th>
                                    <th>Cinema</th>
                                    <th>Order Date</th>
                                    <th>Validity Period</th>
                                </tr>
                                <span class="badge badge-primary badge-sm hidden">Test</span>
                                <span class="badge badge-error badge-sm hidden">Test</span>
                            </thead>
                            <tbody>

                                @for ($i = 0; $i < 15; $i++)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle w-12 h-12">
                                                        <img src="{{ asset('black-panther-poster.jpg') }}"
                                                            alt="Black Panther" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">Black Panther</div>
                                                    @php
                                                        $rand = rand(1, 15);
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $rand % 2 ? 'primary' : 'error' }} badge-sm">{{ $rand % 2 ? 'Downloaded' : 'Not Downloaded' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-sm">Astro Film Lounge</div>
                                        </td>
                                        <td>
                                            {{ now()->format('d M, Y') }}
                                        </td>
                                        <td>{{ now()->addDays(5)->format('d M, Y') }}</td>

                                    </tr>
                                @endfor
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Cinema</th>
                                    <th>Order Date</th>
                                    <th>Validity Period</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    <div class="flex justify-center mt-4 sm:mb-0 mb-5">
                        <div class="join">
                            <button class="join-item btn">«</button>
                            <button class="join-item btn">Page 3</button>
                            <button class="join-item btn">»</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:w-2/6 lg:w-5/12 lg:pl-10 pt-10 hidden lg:block">
            <div>
                <div class='flex max-w-full w-full rounded-lg mx-auto'>
                    <div class="overflow-hidden rounded-xl relative transform hover:-translate-y-2 transition ease-in-out duration-500 shadow-lg hover:shadow-2xl movie-item text-white movie-card"
                        data-movie-id="438631">
                        <div
                            class="absolute inset-0 z-10 transition duration-300 ease-in-out bg-gradient-to-t from-black via-gray-900 to-transparent">
                        </div>
                        <div class="relative cursor-pointer group z-10 px-10 pt-10 space-y-6 movie_info" data-lity=""
                            href="https://www.youtube.com/embed/aSHs224Dge0">
                            <div class="poster__info align-self-end w-full">
                                <div class="h-32"></div>
                                <div class="space-y-6 detail_info">
                                    <div class="flex flex-col space-y-2 inner">
                                        <a class="relative flex items-center w-min flex-shrink-0 p-1 text-center text-white bg-red-500 rounded-full group-hover:bg-red-700"
                                            data-unsp-sanitized="clean">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM9.555 7.168A1 1 0 0 0 8 8v4a1 1 0 0 0 1.555.832l3-2a1 1 0 0 0 0-1.664l-3-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <div
                                                class="absolute transition opacity-0 duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-16 text-xl font-bold text-white group-hover:pr-2">
                                                Trailer</div>
                                        </a>
                                        <h3 class="text-2xl font-bold text-white" data-unsp-sanitized="clean">Dune</h3>
                                        <div class="mb-0 text-lg text-gray-400">Beyond fear, destiny awaits.</div>
                                    </div>
                                    <div class="flex flex-row justify-between datos">
                                        <div class="flex flex-col datos_col">
                                            <div class="popularity">440.052</div>
                                            <div class="text-sm text-gray-400">Popularity:</div>
                                        </div>
                                        <div class="flex flex-col datos_col">
                                            <div class="release">2021-09-15</div>
                                            <div class="text-sm text-gray-400">Release date:</div>
                                        </div>
                                        <div class="flex flex-col datos_col">
                                            <div class="release">155 min</div>
                                            <div class="text-sm text-gray-400">Runtime:</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col overview">
                                        <div class="flex flex-col"></div>
                                        <div class="text-xs text-gray-400 mb-2">Overview:</div>
                                        <p class="text-xs text-gray-100 mb-6">
                                            Paul Atreides, a brilliant and gifted young man born into a great destiny
                                            beyond his understanding, must travel to the most dangerous planet in the
                                            universe to ensure the future of his family and his people. As
                                            malevolent forces explode into conflict over the planet's exclusive supply
                                            of the most precious resource in existence-a commodity capable of unlocking
                                            humanity's greatest potential-only those who can conquer their
                                            fear will survive.
                                        </p>
                                    </div>
                                </div>
                                <div data-countdown="2021-09-15"
                                    class="absolute inset-x-0 top-0 pt-5 w-full mx-auto text-2xl uppercase text-center drop-shadow-sm font-bold text-white">
                                    00 Days 00:00:00</div>
                            </div>
                        </div>
                        <img class="absolute inset-0 transform w-full -translate-y-4"
                            src="http://image.tmdb.org/t/p/w342/s1FhMAr91WL8D5DeHOcuBELtiHJ.jpg"
                            style="filter: grayscale(0);" />
                        <div class="poster__footer flex flex-row relative pb-10 space-x-4 z-10">
                            <a class="flex items-center py-2 px-4 rounded-full mx-auto text-white bg-red-500 hover:bg-red-700"
                                href="http://www.google.com/calendar/event?action=TEMPLATE&amp;dates=20210915T010000Z%2F20210915T010000Z&amp;text=Dune%20%2D%20Movie%20Premiere&amp;location=http%3A%2F%2Fmoviedates.info&amp;details=This%20reminder%20was%20created%20through%20http%3A%2F%2Fmoviedates.info"
                                target="_blank" data-unsp-sanitized="clean">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-sm text-white ml-2">Order Now</div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
