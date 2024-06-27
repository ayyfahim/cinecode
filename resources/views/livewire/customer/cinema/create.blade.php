<div>
    <div class="min-h-screen flex flex-wrap">
        <div class="xl:w-5/6 w-full">
            <div class="prose prose-sm md:prose-base max-w-full flex-grow pt-10">
                <h1>Create Cinemas</h1>
            </div>

            <div class="mt-4 flex flex-wrap gap-4">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                </label>

                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">City</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                </label>
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Country</span>
                    </div>
                    <select class="select select-bordered">
                        <option disabled selected>Pick one</option>
                        <option>Star Wars</option>
                        <option>Harry Potter</option>
                        <option>Lord of the Rings</option>
                        <option>Planet of the Apes</option>
                        <option>Star Trek</option>
                    </select>
                </label>

                <div class="w-full mt-2">
                    <div class="prose prose-sm md:prose-base max-w-full flex-grow">
                        <h3>Emails</h3>
                    </div>

                    <div class="mt-4 flex flex-wrap flex-col gap-4">
                        <div class="flex flex-wrap gap-2 w-full xl:w-5/6">
                            <div class="badge gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="inline-block h-4 w-4 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                test@mail.com
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <label class="input input-bordered flex items-center gap-2 w-full max-w-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 opacity-70">
                                    <path
                                        d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
                                    <path
                                        d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
                                </svg>
                                <input type="text" class="grow" placeholder="Email" />
                            </label>
                            <button class="btn btn-outline w-full max-w-14 border-gray-300">Add</button>
                        </div>

                    </div>
                </div>
            </div>

            <button class="btn mt-4">Create Cinema</button>
        </div>
    </div>
</div>
