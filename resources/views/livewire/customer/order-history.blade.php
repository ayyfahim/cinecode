<div>
    <div class="min-h-screen flex flex-wrap">
        <div class="xl:w-5/6 w-full">
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
                                    <th>Movie</th>
                                    <th>Versions</th>
                                    <th>Cinema</th>
                                    <th>City</th>
                                    <th>Order Date</th>
                                    <th>Validity Period</th>
                                </tr>
                                <span class="badge badge-primary badge-sm hidden">Test</span>
                                <span class="badge badge-error badge-sm hidden">Test</span>
                            </thead>
                            <tbody>

                                @for ($i = 0; $i < 15; $i++)
                                    <tr>
                                        <td class="min-w-60">
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
                                        <td class="min-w-32">
                                            @php
                                                $random_number_array = range(0, rand(0, 3));
                                                shuffle($random_number_array);
                                                $random_number_array = array_slice($random_number_array, 0, 10);
                                            @endphp
                                            @foreach ($random_number_array as $key => $item)
                                                <div
                                                    class="font-medium text-sm text-slate-500 font-mono dark:text-slate-400">
                                                    Version {{ $key + 1 }}</div>
                                            @endforeach
                                        </td>
                                        <td class="min-w-60">
                                            <div class="text-sm">Astro Film Lounge</div>
                                        </td>
                                        <td>
                                            <div class="text-sm">New York</div>
                                        </td>
                                        <td>
                                            {{ now()->format('d/m/Y') }}
                                        </td>
                                        <td class="min-w-60">
                                            <div>
                                                <span class="text-sm font-medium">Start
                                                    Date: </span>{{ now()->format('d/m/Y') }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium">End
                                                    Date: </span>{{ now()->addDays(5)->format('d/m/Y') }}
                                            </div>

                                        </td>

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

        <div></div>
    </div>
</div>
