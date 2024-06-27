<div>
    {{-- <div class="">
        <div class="grid rounded-3xl max-w-[350px] shadow-xl bg-white flex-col cursor-pointer">
            <img src="{{ asset('black-panther-poster.jpg') }}" width="350" height="200"
                class="rounded-t-3xl justify-center grid h-80 object-cover" />

            <div class="group p-6 grid z-10">
                <a href="#" class="group-hover:text-cine-highlight-1 font-bold sm:text-2xl line-clamp-2">
                    Black Panther
                </a>
                <span class="text-slate-400 pt-2 font-semibold"> (2024) </span>
                <div class="h-28">
                    <span class="line-clamp-4 py-2 text-sm font-light leading-relaxed">
                        After his father's death, T'Challa returns home to Wakanda to inherit his throne. However, a
                        powerful enemy related to his family threatens to attack his nation.
                    </span>
                </div>
                <button
                    class="group-hover:bg-cine-highlight-1 block w-full select-none rounded-lg bg-blue-gray-900/10 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-blue-gray-900 focus:opacity-[0.85] active:scale-100 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none hover:bg-blue-gray-900/20 transition-all"
                    type="button" @click="modelOpen =!modelOpen">
                    Order Now
                </button>
            </div>
        </div>
    </div> --}}
    <div>
        <div class="card w-full bg-base-100 shadow-xl cursor-pointer" @click="modelOpen =!modelOpen">
            <figure><img src="{{ asset('black-panther-poster.jpg') }}" alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Black Panther</h2>
                <p class="text-sm">Wakanda Forever!</p>
            </div>
        </div>
    </div>
</div>
