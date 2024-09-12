<div>
    <div class="min-h-screen flex flex-col flex-wrap justify-center content-center gap-8" x-data="{
        eulaAccepted: @entangle('eula')
    }">
        <div class="card lg:max-w-lg w-full bg-base-100 shadow-xl" id="step-1">
            <div class="card-body">
                <h2 class="card-title">{{ __('cinema_frontend.download_cinecode_player_lite') }}</h2>
                <p class="mb-11">{{ __('cinema_frontend.please_select_a_platform') }}</p>

                <div class="flex flex-row gap-2 justify-center">
                    <div class="card bg-transparent text-neutral-content w-28 border border-neutral-content cursor-pointer"
                        wire:click="downloadPlayer('windows')">
                        <div class="card-body items-center text-center !py-3 !px-0">
                            <div>
                                <svg height="35px" width="35px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 452.986 452.986" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path style="fill:#010002;" d="M165.265,53.107L21.689,81.753v132.531l143.575-2.416V53.107 M431.297,245.583l-233.18-3.991
   v164.822l233.18,46.571V245.583 M165.265,241.097l-143.575-2.438v132.509l143.575,28.668V241.097 M431.297,0l-233.18,46.528
   v164.822l233.18-3.969V0" />
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </g>
                                </svg>
                            </div>

                            <h5 class="text-neutral text-sm">{{ __('cinema_frontend.windows') }}</h5>
                        </div>
                    </div>
                    <div class="card bg-transparent text-neutral-content w-28 border border-neutral-content cursor-pointer"
                        wire:click="downloadPlayer('mac_sil')">
                        <div class="card-body items-center text-center !py-3 !px-0">
                            <div>

                                <svg class="svg-icon"
                                    style="width: 35px; height: 35px;vertical-align: middle;overflow: hidden;"
                                    viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M849.124134 704.896288c-1.040702 3.157923-17.300015 59.872622-57.250912 118.190843-34.577516 50.305733-70.331835 101.018741-126.801964 101.909018-55.532781 0.976234-73.303516-33.134655-136.707568-33.134655-63.323211 0-83.23061 32.244378-135.712915 34.110889-54.254671 2.220574-96.003518-54.951543-130.712017-105.011682-70.934562-102.549607-125.552507-290.600541-52.30118-416.625816 36.040844-63.055105 100.821243-103.135962 171.364903-104.230899 53.160757-1.004887 103.739712 36.012192 136.028093 36.012192 33.171494 0 94.357018-44.791136 158.90615-38.089503 27.02654 1.151219 102.622262 11.298324 151.328567 81.891102-3.832282 2.607384-90.452081 53.724599-89.487104 157.76107C739.079832 663.275355 847.952448 704.467523 849.124134 704.896288M633.69669 230.749408c29.107945-35.506678 48.235584-84.314291 43.202964-132.785236-41.560558 1.630127-92.196819 27.600615-122.291231 62.896492-26.609031 30.794353-50.062186 80.362282-43.521213 128.270409C557.264926 291.935955 604.745311 264.949324 633.69669 230.749408" />
                                </svg>
                            </div>

                            <h5 class="text-neutral text-sm">{{ __('cinema_frontend.macos_silicon') }}</h5>
                        </div>
                    </div>
                    <div class="card bg-transparent text-neutral-content w-28 border border-neutral-content cursor-pointer"
                        wire:click="downloadPlayer('mac_intel')">
                        <div class="card-body items-center text-center !py-3 !px-0">
                            <div>

                                <svg class="svg-icon"
                                    style="width: 35px; height: 35px;vertical-align: middle;overflow: hidden;"
                                    viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M849.124134 704.896288c-1.040702 3.157923-17.300015 59.872622-57.250912 118.190843-34.577516 50.305733-70.331835 101.018741-126.801964 101.909018-55.532781 0.976234-73.303516-33.134655-136.707568-33.134655-63.323211 0-83.23061 32.244378-135.712915 34.110889-54.254671 2.220574-96.003518-54.951543-130.712017-105.011682-70.934562-102.549607-125.552507-290.600541-52.30118-416.625816 36.040844-63.055105 100.821243-103.135962 171.364903-104.230899 53.160757-1.004887 103.739712 36.012192 136.028093 36.012192 33.171494 0 94.357018-44.791136 158.90615-38.089503 27.02654 1.151219 102.622262 11.298324 151.328567 81.891102-3.832282 2.607384-90.452081 53.724599-89.487104 157.76107C739.079832 663.275355 847.952448 704.467523 849.124134 704.896288M633.69669 230.749408c29.107945-35.506678 48.235584-84.314291 43.202964-132.785236-41.560558 1.630127-92.196819 27.600615-122.291231 62.896492-26.609031 30.794353-50.062186 80.362282-43.521213 128.270409C557.264926 291.935955 604.745311 264.949324 633.69669 230.749408" />
                                </svg>
                            </div>

                            <h5 class="text-neutral text-sm">{{ __('cinema_frontend.macos_intel') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal wire:model="downloadModal" persistent>
            <div class="prose ">
                {!! __('cinema_frontend.terms') !!}

                <label class="cursor-pointer label justify-normal">
                    <input type="checkbox" wire:model='eula'
                        class="checkbox [--chkbg:theme(colors.cine-highlight-1)] border-cine-highlight-1" />
                    <span class="label-text ml-3">
                        {{ __('cinema_frontend.ich_akzeptiere_die_nutzungsbedingungen') }}</span>
                </label>
            </div>
            <x-slot:actions>
                <x-button label="{{ __('cinema_frontend.cancel') }}" @click="$wire.downloadModal = false" />
                <x-button label="{{ __('cinema_frontend.confirm') }}" class="btn-cine-highlight-1"
                    x-bind:disabled="!eulaAccepted" wire:click='confirmDownloadPlayer()' />
            </x-slot:actions>
        </x-modal>
    </div>
</div>
