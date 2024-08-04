<div>
    <div class="min-h-screen flex flex-col flex-wrap justify-center content-center gap-8">
        <div class="card lg:max-w-lg w-full bg-base-100 shadow-xl" id="step-1">
            <div class="card-body">
                <button class="btn btn-circle">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="96.108px" height="122.88px"
                        viewBox="0 0 96.108 122.88" enable-background="new 0 0 96.108 122.88" xml:space="preserve"
                        class="h-6 w-6">
                        <g>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.892,56.036h8.959v-1.075V37.117c0-10.205,4.177-19.484,10.898-26.207v-0.009 C29.473,4.177,38.754,0,48.966,0C59.17,0,68.449,4.177,75.173,10.901l0.01,0.009c6.721,6.723,10.898,16.002,10.898,26.207v17.844 v1.075h7.136c1.59,0,2.892,1.302,2.892,2.891v61.062c0,1.589-1.302,2.891-2.892,2.891H2.892c-1.59,0-2.892-1.302-2.892-2.891 V58.927C0,57.338,1.302,56.036,2.892,56.036L2.892,56.036z M26.271,56.036h45.387v-1.075V36.911c0-6.24-2.554-11.917-6.662-16.03 l-0.005,0.004c-4.111-4.114-9.787-6.669-16.025-6.669c-6.241,0-11.917,2.554-16.033,6.665c-4.109,4.113-6.662,9.79-6.662,16.03 v18.051V56.036L26.271,56.036z M49.149,89.448l4.581,21.139l-12.557,0.053l3.685-21.423c-3.431-1.1-5.918-4.315-5.918-8.111 c0-4.701,3.81-8.511,8.513-8.511c4.698,0,8.511,3.81,8.511,8.511C55.964,85.226,53.036,88.663,49.149,89.448L49.149,89.448z" />
                        </g>
                    </svg>
                </button>

                <h2 class="card-title">Customer Portal</h2>
                <p class="font-medium text-base-content text-opacity-65 text-sm">Sign In</p>
                <form wire:submit="login">
                    <input type="email" placeholder="Email Address" class="input input-bordered w-full mt-4 mb-2"
                        wire:model='email' />
                    <input type="password" placeholder="Password" class="input input-bordered w-full mb-2"
                        wire:model='password' />

                    <a href="{{ route('customer.password.request') }}" class="font-medium text-primary text-sm">Forgot
                        or lost your password?</a>

                    <div class="w-full flex flex-wrap justify-between mt-3">
                        <div class="card-actions justify-start">
                            <button type="submit"
                                class="btn btn-cine-highlight-1 text-opacity-100 font-bold">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
