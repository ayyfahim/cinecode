<div>
    <div class="mb-6">
        <div class="grid sm:grid-cols-3 grid-cols-2 gap-3">
            <label class="input input-bordered flex items-center gap-2 h-10 sm:w-72 w-full">
                <input type="text" class="grow" placeholder="Search" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
                    <path fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                </svg>
            </label>

            <div class="sm:col-span-2 justify-self-end">

                <livewire:components.sort-menu />
            </div>
        </div>
    </div>
    <div class="grid gap-4 xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3 grid-cols-2">
        @for ($i = 0; $i < 30; $i++)
            <livewire:customer.shop-card :key="$i" :product_id="$i" />
        @endfor
    </div>
    <div class="flex justify-center mt-6">
        {{-- grid-cols-2 --}}
        <div class="join">
            <button class="join-item btn">«</button>
            <button class="join-item btn">Page 3</button>
            <button class="join-item btn">»</button>
        </div>
    </div>

</div>
