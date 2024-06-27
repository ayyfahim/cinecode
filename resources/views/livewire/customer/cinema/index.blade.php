<div>
    <div class="min:h-screen flex flex-wrap" x-data="{ deleteModal: false }">
        <div class="xl:w-5/6 w-full">
            <div class="prose prose-sm md:prose-base max-w-full flex-grow pt-10">
                <h1>Cinemas</h1>
                <div class="flex flex-wrap sm:flex-row flex-col justify-between">
                    <p class="!mt-0">15 Cinemas</p>
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
                        <livewire:components.order-history-filter-menu />
                        <a href="{{ route('customer.settings.cinema.create') }}" class="btn btn-square btn-sm h-10 w-10"
                            tabindex="0" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-base-content"
                                viewBox="0 0 1000 1000">
                                <metadata>IcoFont Icons</metadata>
                                <title>plus</title>
                                <glyph glyph-name="plus" unicode="&#xefc2;" horiz-adv-x="1000" />
                                <path
                                    d="M935.4 459.6c-1-14.100000000000023-3.1000000000000227-29.200000000000045-6.7999999999999545-45.30000000000001h-343v-343c-16.100000000000023-3.6000000000000085-30.700000000000045-5.700000000000017-43.80000000000007-6.800000000000011-12.5-1.6000000000000014-25.5-2.1000000000000014-38.49999999999994-2.1000000000000014-15.100000000000023 0-29.69999999999999 0.5-43.69999999999999 2.1000000000000014-14.100000000000023 1-29.200000000000045 3.0999999999999943-45.30000000000001 6.799999999999997v343h-343c-3.6000000000000085 16.099999999999966-6.300000000000011 30.69999999999999-7.300000000000011 43.69999999999999-1 13-1.6000000000000014 25.5-1.6000000000000014 38.5 0 15.100000000000023 0.5 29.700000000000045 1.6000000000000014 43.700000000000045 1 14.099999999999909 3.5999999999999943 29.199999999999932 7.299999999999997 45.299999999999955h343v343c16.099999999999966 3.6000000000000227 30.69999999999999 6.2999999999999545 43.69999999999999 7.2999999999999545 13 1 25.5 1.6000000000000227 38.5 1.6000000000000227 15.100000000000023 0 29.700000000000045-0.5 43.700000000000045-1.6000000000000227 14.099999999999909-1 29.199999999999932-3.599999999999909 45.299999999999955-7.2999999999999545v-343h343c3.6000000000000227-16.100000000000023 5.7000000000000455-30.700000000000045 6.7999999999999545-43.799999999999955 1.6000000000000227-12.5 2.1000000000000227-25.5 2.1000000000000227-38.50000000000006 0.10000000000002274-14.899999999999977-0.39999999999997726-29.5-2-43.599999999999966z" />
                            </svg>
                        </a>
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
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Downloaded Player</th>
                                    <th></th>
                                </tr>
                                <span class="badge badge-primary badge-sm hidden">Test</span>
                                <span class="badge badge-error badge-sm hidden">Test</span>
                            </thead>
                            <tbody>

                                @for ($i = 0; $i < 15; $i++)
                                    <tr>
                                        <td class="min-w-60">
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <div class="font-bold">Cinema #{{ $i + 1 }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="min-w-32">
                                            <div class="text-sm">City #{{ $i + 1 }}</div>
                                        </td>
                                        <td class="min-w-32">
                                            <div class="text-sm">Country #{{ $i + 1 }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                @php
                                                    $rand = rand(1, 15);
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $rand % 2 ? 'primary' : 'error' }} badge-sm">{{ $rand % 2 ? 'Downloaded' : 'Not Downloaded' }}</span>
                                            </div>
                                        </td>
                                        <th class="min-w-40">
                                            <button class="btn btn-ghost btn-xs">edit</button>
                                            <button class="btn btn-ghost btn-xs"
                                                x-on:click="deleteModal = !deleteModal">delete</button>
                                        </th>

                                    </tr>
                                @endfor
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Downloaded Player</th>
                                    <th></th>
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

        <div class="modal" role="dialog" id="my_modal_8" x-show="deleteModal" :open="deleteModal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Are you Sure?</h3>
                <p class="py-4">Once you delete you can't restore!</p>
                <div class="modal-action">
                    <button class="btn btn-error" @click="deleteModal = !deleteModal">Yes, sure.</button>
                    <button class="btn" @click="deleteModal = !deleteModal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
