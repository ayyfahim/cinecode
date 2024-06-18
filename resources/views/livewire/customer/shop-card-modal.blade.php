<div>
    <div x-show="modelOpen" class="fixed z-10 inset-0 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div x-show="modelOpen"
            class="relative bg-cine-neutral/90 rounded-lg overflow-hidden shadow-xl max-w-screen-md w-full m-4"
            x-transition:enter="transition ease-out duration-300 transform opacity-0 scale-95"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform opacity-100 scale-100"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="max-w-screen-md p-8 overflow-y-auto text-white grid md:grid-cols-4 md:gap-6"
                style="max-height: 70vh; border-radius: 0.375rem; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">

                <div class="col-span-1">
                    <figure>
                        <img src="{{ asset('black-panther-poster.jpg') }}" class="md:w-full max-w-36" alt="Shoes" />
                    </figure>
                </div>
                <div class="col-span-3 grid grid-flow-rows gap-y-5">
                    <h2 class="text-2xl font-bold">Black Panther</h2>
                    <div class="flex flex-wrap gap-x-3 items-center">
                        <h3 class="text-sm font-semibold">Version</h3>
                        <select class="select select-bordered select-xs w-full max-w-40 text-black">
                            <option disabled selected>Small</option>
                            <option>Small Apple</option>
                            <option>Small Orange</option>
                            <option>Small Tomato</option>
                        </select>
                    </div>
                    <livewire:components.calendar />
                    <div class="flex flex-wrap gap-x-3 items-center">
                        <h3 class="text-sm font-semibold">Cinema</h3>
                        <div class="flex flex-wrap gap-x-2 items-center">
                            <input type="text" class="input input-bordered input-xs text-neutral"
                                placeholder="Enter cinema, city or group..." />
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="w-6 h-6 cursor-pointer">
                                <path fill-rule="evenodd"
                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold">No Group Found.</h3>
                    </div>
                    <div
                        class="grid grid-flow-rows border-gray-500 p-2 overflow-y-scroll border rounded max-h-60 gap-y-2">
                        @for ($i = 0; $i < 30; $i++)
                            <div class="grid grid-cols-4 gap-3 justify-items-center items-center">
                                <h4 class="text-sm font-semibold justify-self-start">Cinema #{{ $i + 1 }}</h4>
                                <h4 class="text-sm font-semibold">City #{{ $i + 1 }}</h4>
                                <h4 class="text-sm font-semibold">Country #{{ $i + 1 }}</h4>
                                <input type="checkbox" checked="checked" class="checkbox justify-self-end" />
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 flex align-items justify-end p-4 gap-4 flex-col">
                <div class="sm:flex sm:flex-wrap hidden">
                    @for ($i = 0; $i < 30; $i++)
                        <h4 class="text-sm font-semibold text-white">Cinema #{{ $i + 1 }},</h4>
                    @endfor
                </div>
                <button @click="modelOpen = false" type="button"
                    class="inline-flex self-end text-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  sm:w-auto sm:text-sm max-w-40">
                    Confirm Order </button>
            </div>
        </div>
    </div>
</div>
