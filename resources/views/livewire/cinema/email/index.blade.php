<div>
    <div class="min-h-screen">
        <div class="prose prose-sm md:prose-base max-w-full flex-grow pt-10">
            <h1>{{ __('cinema_frontend.emails') }}</h1>
            <div class="text-red-500 label-text-alt p-1 hidden"></div>
            <div class="flex flex-wrap sm:flex-row flex-col justify-between">
                <p class="!mt-0">{{ $emails->total() }} {{ __('cinema_frontend.emails') }}</p>

                <div class="flex flex-wrap items-center gap-4">
                    <label class="input input-bordered flex items-center gap-2 h-10 sm:w-72 w-52">
                        <input type="text" class="grow" placeholder="{{ __('cinema_frontend.search') }}"
                            wire:model.live.debounce.250ms='search_query' />
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="w-4 h-4 opacity-70">
                            <path fill-rule="evenodd"
                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </label>

                    <div class="btn btn-square btn-sm h-10 w-10" tabindex="0" role="button"
                        @click="$wire.emailCreateModal = true, $wire.editedEmail = '', $wire.selectedEmail = null">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 1000 1000"
                            class="w-5 h-5 fill-base-content" fill="currentColor">
                            <metadata>IcoFont Icons</metadata>
                            <title>plus</title>
                            <glyph glyph-name="plus" unicode="&#xefc2;" horiz-adv-x="1000" />
                            <path
                                d="M935.4 459.6c-1-14.100000000000023-3.1000000000000227-29.200000000000045-6.7999999999999545-45.30000000000001h-343v-343c-16.100000000000023-3.6000000000000085-30.700000000000045-5.700000000000017-43.80000000000007-6.800000000000011-12.5-1.6000000000000014-25.5-2.1000000000000014-38.49999999999994-2.1000000000000014-15.100000000000023 0-29.69999999999999 0.5-43.69999999999999 2.1000000000000014-14.100000000000023 1-29.200000000000045 3.0999999999999943-45.30000000000001 6.799999999999997v343h-343c-3.6000000000000085 16.099999999999966-6.300000000000011 30.69999999999999-7.300000000000011 43.69999999999999-1 13-1.6000000000000014 25.5-1.6000000000000014 38.5 0 15.100000000000023 0.5 29.700000000000045 1.6000000000000014 43.700000000000045 1 14.099999999999909 3.5999999999999943 29.199999999999932 7.299999999999997 45.299999999999955h343v343c16.099999999999966 3.6000000000000227 30.69999999999999 6.2999999999999545 43.69999999999999 7.2999999999999545 13 1 25.5 1.6000000000000227 38.5 1.6000000000000227 15.100000000000023 0 29.700000000000045-0.5 43.700000000000045-1.6000000000000227 14.099999999999909-1 29.199999999999932-3.599999999999909 45.299999999999955-7.2999999999999545v-343h343c3.6000000000000227-16.100000000000023 5.7000000000000455-30.700000000000045 6.7999999999999545-43.799999999999955 1.6000000000000227-12.5 2.1000000000000227-25.5 2.1000000000000227-38.50000000000006 0.10000000000002274-14.899999999999977-0.39999999999997726-29.5-2-43.599999999999966z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <x-table :headers="$headers" :rows="$emails" with-pagination>

            @scope('cell_fakeColumn', $email)
                <u>{{ $loop->index + 1 }}</u>
            @endscope

            @scope('cell_email', $email)
                <strong>{{ $email->email }}</strong>
            @endscope

            {{-- Special `actions` slot --}}
            @scope('actions', $email)
                <x-button icon="o-document" wire:click="edit({{ $email->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $email->id }})" spinner class="btn-sm" />
            @endscope

        </x-table>

        <x-modal wire:model="emailCreateModal" class="backdrop-blur" box-class="bg-cine-neutral/90">
            <label class="pt-0 label label-text font-semibold text-white">
                <span>
                    {{ __('cinema_frontend.email') }}
                </span>
            </label>
            <x-input placeholder="{{ __('cinema_frontend.enter_your_email') }}" wire:model="email" />
            <x-slot:actions>
                <x-button label="{{ __('cinema_frontend.save') }}" wire:click='createEmail'
                    class="bg-black text-white border-transparent hover:bg-black hover:text-white hover:border-transparent" />
                <x-button label="{{ __('cinema_frontend.cancel') }}"
                    class="bg-black text-white border-transparent hover:bg-black hover:text-white hover:border-transparent"
                    @click="$wire.emailCreateModal = false, $wire.email = '', $wire.selectedEmail = null" />
            </x-slot:actions>
        </x-modal>

        <x-modal wire:model="editModal" class="backdrop-blur">
            <x-input label="{{ __('cinema_frontend.email') }}" placeholder="{{ $selectedEmail?->email }}"
                wire:model="editedEmail" />
            <x-slot:actions>
                <x-button label="{{ __('cinema_frontend.save') }}" wire:click='saveEmail' />
                <x-button label="{{ __('cinema_frontend.cancel') }}"
                    @click="$wire.editModal = false, $wire.editedEmail = '', $wire.selectedEmail = null" />
            </x-slot:actions>
        </x-modal>

        <x-modal wire:model="deleteModal" class="backdrop-blur" title="Are you sure?">
            <div>{{ __('cinema_frontend.click_cancel_or_press_esc_to_exit') }}</div>
            <x-slot:actions>
                <x-button label="{{ __('cinema_frontend.cancel') }}"
                    @click="$wire.deleteModal = false, $wire.editedEmail = '', $wire.selectedEmail = null" />
                <x-button label="{{ __('cinema_frontend.confirm') }}" class="btn-primary" wire:click='deleteEmail' />
            </x-slot:actions>
        </x-modal>
    </div>
</div>
