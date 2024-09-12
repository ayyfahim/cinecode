<div>
    <div class="min-h-screen flex flex-col flex-wrap justify-center content-center gap-8">
        <div class="card lg:max-w-lg w-full bg-base-100 shadow-xl" id="step-1">
            <div class="card-body">

                <h2 class="card-title">{{ __('cinema_frontend.cinema_portal') }}</h2>
                <p class="font-medium text-base-content text-opacity-65 text-sm">
                    {{ __('cinema_frontend.download_player') }}</p>
                <form wire:submit="downloadPlayer">

                    <label class="cursor-pointer label justify-normal">
                        <input type="checkbox" wire:model='term'
                            class="checkbox [--chkbg:theme(colors.cine-highlight-1)] border-cine-highlight-1" />
                        <span class="label-text ml-3">{{ __('cinema_frontend.i_here_by_accept_the') }} <a href="#"
                                class="font-semibold text-cine-highlight-1">{{ __('cinema_frontend.terms') }}</a></span>
                    </label>

                    <div class="w-full flex flex-wrap justify-between mt-3">
                        <div class="card-actions justify-start">
                            <button type="submit"
                                class="btn btn-cine-highlight-1 text-opacity-100 font-bold">{{ __('cinema_frontend.download') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
