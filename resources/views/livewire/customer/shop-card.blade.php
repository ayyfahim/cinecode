<div>
    <div>
        <div class="card w-full bg-base-100 shadow-xl cursor-pointer"
            wire:click="$dispatch('shop-select-movie', { value: {{ $movie }} })">
            <figure>
                <img src="{{ Storage::disk('public')->exists($movie->poster_image) ? Storage::disk('public')->url($movie->poster_image) : $movie->poster_image }}"
                    alt="{{ $movie->name }}" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $movie->name }}</h2>
            </div>
        </div>
    </div>
</div>
