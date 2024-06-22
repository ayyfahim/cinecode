<div>
    <div class="antialiased sans-serif">
        <div x-data="calendar" x-cloak>
            <div class="">
                <div>
                    <div class="relative" @keydown.escape="closeDatepicker()" @click.outside="closeDatepicker()">
                        <div class="sm:flex hidden flex-wrap md:gap-3 gap-2 items-center">
                            <h3 class="text-sm font-semibold">Validity Period</h3>
                            <h4 class="text-sm font-semibold">from</h4>
                            <input type="text" class="input input-bordered input-xs text-neutral"
                                @click="endToShow = 'from'; init(); showDatepicker = true" x-model="outputDateFromValue"
                                :class="{ 'font-semibold': endToShow == 'from' }" />
                            <h4 class="text-sm font-semibold">to</h4>
                            <input type="text" class="input input-bordered input-xs text-neutral"
                                @click="endToShow = 'to'; init(); showDatepicker = true" x-model="outputDateToValue"
                                :class="{ 'font-semibold': endToShow == 'to' }" />
                        </div>
                        <div class="flex sm:hidden flex-wrap flex-col md:gap-3 gap-2">
                            <div class="flex flex-wrap gap-1">
                                <h3 class="text-sm font-semibold">Validity Period</h3>
                                <h4 class="text-sm font-semibold">from:</h4>
                                <div class="w-full"></div>
                                <input type="text" class="input input-bordered input-xs text-neutral"
                                    @click="endToShow = 'from'; init(); showDatepicker = true"
                                    x-model="outputDateFromValue" :class="{ 'font-semibold': endToShow == 'from' }" />
                            </div>
                            <div class="flex flex-wrap gap-1">
                                <h3 class="text-sm font-semibold">Validity Period</h3>
                                <h4 class="text-sm font-semibold">to:</h4>
                                <div class="w-full"></div>
                                <input type="text" class="input input-bordered input-xs text-neutral"
                                    @click="endToShow = 'to'; init(); showDatepicker = true" x-model="outputDateToValue"
                                    :class="{ 'font-semibold': endToShow == 'to' }" />
                            </div>
                        </div>
                        <div class="absolute bg-white mt-2 rounded-lg shadow p-4 sm:w-80 w-full text-neutral"
                            x-show="showDatepicker" x-transition>
                            <div class="flex flex-col items-center">

                                <div class="w-full flex justify-between items-center mb-2">
                                    <div>
                                        <span x-text="MONTH_NAMES[month]"
                                            class="text-lg font-bold text-gray-800"></span>
                                        <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                    </div>
                                    <div>
                                        <button type="button"
                                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                            @click="if (month == 0) {year--; month=11;} else {month--;} getNoOfDays()">
                                            <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                            @click="if (month == 11) {year++; month=0;} else {month++;}; getNoOfDays()">
                                            <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="w-full flex flex-wrap mb-3 -mx-1">
                                    <template x-for="(day, index) in DAYS" :key="index">
                                        <div style="width: 14.26%" class="px-1">
                                            <div x-text="day" class="text-gray-800 font-medium text-center text-xs">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex flex-wrap -mx-1">
                                    <template x-for="blankday in blankdays">
                                        <div style="width: 14.28%"
                                            class="text-center border p-1 border-transparent text-sm"></div>
                                    </template>
                                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                        <div style="width: 14.28%">
                                            <div @click="getDateValue(date, false)"
                                                @mouseenter="getDateValue(date, true)" x-text="date"
                                                class="p-1 cursor-pointer text-center text-sm leading-none leading-loose transition ease-in-out duration-100"
                                                :class="{
                                                    'font-bold': isToday(date) ==
                                                        true,
                                                    'bg-cine-highlight-1 text-white rounded-l-full': isDateFrom(date) ==
                                                        true,
                                                    'bg-cine-highlight-1 text-white rounded-r-full': isDateTo(date) ==
                                                        true,
                                                    'bg-cine-highlight-1/40': isInRange(date) == true
                                                }">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div>
                                    <button @click="showDatepicker = false"
                                        class="px-2 py-1 border border-gray-300 hover:border-gray-500 rounded-md">Cancel</button>
                                    <button @click="outputDateValues(); showDatepicker = false"
                                        class="px-2 py-1 border border-cine-highlight-1 bg-cine-highlight-1 hover:bg-cine-highlight-1/40 text-white rounded-md">OK</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
