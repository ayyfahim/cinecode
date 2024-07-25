<div class="p-0">
    <div x-show="modelOpen" class="fixed z-[60] inset-0 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div x-show="modelOpen"
            class="relative bg-cine-neutral/90 rounded-lg overflow-hidden shadow-xl max-w-screen-md w-full m-4 max-h-screen h-96 flex flex-col justify-between"
            x-transition:enter="transition ease-out duration-300 transform opacity-0 scale-95"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform opacity-100 scale-100"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="max-w-screen-md p-8 overflow-y-auto text-white h-full"
                style="border-radius: 0.375rem; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">

                <div class="flex flex-col items-center justify-center gap-y-4">
                    <h2 class="text-2xl font-bold">{{ $editMode ? 'Edit Cinema Group' : 'Add Cinema Group' }}</h2>

                    <div class="flex flex-wrap gap-x-3 items-center">
                        <h3 class="text-sm font-semibold">Group Name</h3>
                        <div class="flex flex-wrap gap-x-2 items-center">
                            <input type="text" class="input input-bordered input-xs text-white"
                                placeholder="Enter group name" wire:model="group_name" />
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-x-3 items-center">
                        <h3 class="text-sm font-semibold">Cinema</h3>
                        <div class="flex flex-wrap gap-x-2 items-center relative">
                            <input wire:model.live.debounce.250ms="search_cinema" type="text"
                                class="input input-bordered input-xs text-white"
                                placeholder="Enter cinema, city or country" />
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="w-6 h-6 cursor-pointer">
                                <path fill-rule="evenodd"
                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            @if ($cinemas->count())
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] p-2 shadow-2xl bg-base-300 rounded-box w-52 absolute top-7 right-0 max-h-56 overflow-y-auto">
                                    @foreach ($cinemas as $cinema)
                                        <li>
                                            <input type="radio"
                                                class="theme-controller btn btn-sm btn-block btn-ghost justify-start checked:!bg-cine-neutral checked:!text-neutral-content checked:!border-cine-neutral"
                                                aria-label="{{ $cinema->name }}" value="{{ $cinema->id }}"
                                                name="selectedCinema" wire:click="selectCinema({{ $cinema->id }})" />
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    @if ($selectedCinemas->count())
                        <div class="sm:flex sm:flex-wrap hidden items-center gap-[5px]">
                            @foreach ($selectedCinemas as $cinema)
                                <h4 class="text-sm font-semibold text-white">
                                    {{ $cinema['name'] }} ({{ $cinema['city_name'] }}){{ !$loop->last ? ',' : '' }}</h4>
                                <button class="btn btn-circle btn-outline w-[10px] min-h-[10px] max-h-[10px]"
                                    wire:click="cancelCinema({{ $cinema->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    @endif


                    @if ($cinemaGroups->count() && !$editMode)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Group Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cinemaGroups as $key => $c_group)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $c_group->name }}</td>
                                            <td><button class="btn btn-ghost btn-xs"
                                                    wire:click="editCinemaGroup({{ $c_group->id }})">Edit</button>
                                                {{-- <button class="btn btn-ghost btn-xs">Delete</button> --}}
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 flex align-items justify-end p-4 gap-4 flex-row" x-data="{ isLoading: $wire.entangle('isLoading'), editMode: $wire.entangle('editMode') }">
                <button type="button"
                    class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40 {{ $isLoading ? 'text-gray-500' : '' }}"
                    wire:click='toggleModal'>
                    Close </button>
                <button type="button"
                    class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40 {{ $isLoading ? 'text-gray-500' : '' }}"
                    wire:click='cancelEditCinemaGroup' x-show="editMode">
                    Cancel Edit </button>
                <button type="button"
                    class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40 items-center gap-2"
                    wire:click='updateCinemaGroup' x-show="editMode">
                    <span class="loading loading-spinner w-4" x-show="isLoading"></span>
                    Update
                </button>
                <button type="button"
                    class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40 items-center gap-2"
                    wire:click='addCinemaGroup' x-show="!editMode">
                    <span class="loading loading-spinner w-4" x-show="isLoading"></span>
                    Add
                </button>

            </div>
        </div>
    </div>
</div>
