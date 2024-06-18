<div>
    <div class="antialiased sans-serif">
        <div x-data="calendar" x-cloak>
            <div class="container mx-auto py-2 md:py-10">
                <div>
                    <span class="font-bold my-1 text-gray-700 block">Results (would normally be hidden)</span>
                    <input type="text" name="date_from" x-model="dateFromYmdHis">
                    <input type="text" name="date_to" x-model="dateToYmdHis" class="mt-2 sm:mt-0 ml-0 sm:ml-2">
                    <label for="timemode" class="font-bold mt-3 mb-1 text-gray-700 block">Time Input Mode</label>
                    <select id="timemode" x-model="timeMode" @change="changeTimeMode()"
                        class="focus:outline-none border-none p-2 rounded-md border-r border-gray-300">
                        <option value=12>12 Hour Clock</option>
                        <option value=24>24 Hour Clock</option>
                    </select>
                    <label for="datepicker" class="font-bold mt-3 mb-1 text-gray-700 block">Select Date/Time
                        Range</label>
                    <div class="relative" @keydown.escape="closeDatepicker()" @click.outside="closeDatepicker()">
                        <div class="inline-flex items-center border rounded-md mt-3 bg-gray-200">
                            <input type="text" @click="endToShow = 'from'; init(); showDatepicker = true"
                                x-model="outputDateFromValue" :class="{ 'font-semibold': endToShow == 'from' }"
                                class="focus:outline-none border-none p-2 w-64 rounded-l-md border-r border-gray-300" />
                            <div class="inline-block px-2 h-full">to</div>
                            <input type="text" @click="endToShow = 'to'; init(); showDatepicker = true"
                                x-model="outputDateToValue" :class="{ 'font-semibold': endToShow == 'to' }"
                                class="focus:outline-none border-none p-2 w-64 rounded-r-md border-l border-gray-300" />
                        </div>
                        <div class="absolute bg-white mt-2 rounded-lg shadow p-4 sm:w-80 w-full" x-show="showDatepicker"
                            x-transition>
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
                                                    'bg-blue-800 text-white rounded-l-full': isDateFrom(date) ==
                                                        true,
                                                    'bg-blue-800 text-white rounded-r-full': isDateTo(date) ==
                                                        true,
                                                    'bg-blue-200': isInRange(date) == true
                                                }">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex items-center my-3 border border-gray-300 rounded-md bg-gray-200"
                                    :class="{ 'cursor-not-allowed': timePickerDisabled }">
                                    <div class="inline-flex items-center h-full px-2 py-1 rounded-l-md bg-white">
                                        <div class="flex flex-col items-center">
                                            <div class="relative">
                                                <input @click="showFromHourPicker=true" type="text" value="12"
                                                    x-model="hourFromValue"
                                                    :class="{
                                                        'font-bold': showFromHourPicker ==
                                                            true,
                                                        'cursor-not-allowed': timePickerDisabled
                                                    }"
                                                    class="focus:outline-none w-6 text-center border-none p-0" readonly
                                                    x-bind:disabled="timePickerDisabled" />
                                                <div class="absolute bg-white rounded-lg shadow p-2"
                                                    x-show="showFromHourPicker" x-transition
                                                    @click.outside="showFromHourPicker=false">
                                                    <div :class="{ 'w-40': timeMode == 24 }">
                                                        <template x-for="hour in hoursFrom" :key="hour.id">
                                                            <div :style="timeMode == 24 && { width: '16.666666%' }"
                                                                @click="if (!hour.disabled) {getHour('from', hour.id);  showToHourPicker=false;}"
                                                                x-text="hour.label" class="px-1 hover:bg-blue-200"
                                                                :class="{
                                                                    'cursor-not-allowed opacity-25': hour
                                                                        .disabled,
                                                                    'float-left': timeMode ==
                                                                        24,
                                                                    'clear-both': timeMode == 24 && hour.id > 0 &&
                                                                        hour.id % 6 === 0
                                                                }"
                                                                :disabled="hour.disabled"></div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inline-block px-1 h-full">:</div>
                                        <div class="relative">
                                            <input @click="showFromMinutePicker=true" type="text"
                                                x-model="minuteFromValue"
                                                :class="{
                                                    'font-bold': showFromMinutePicker ==
                                                        true,
                                                    'cursor-not-allowed': timePickerDisabled
                                                }"
                                                class="focus:outline-none w-6 text-center border-none p-0" readonly
                                                x-bind:disabled="timePickerDisabled" />
                                            <div class="absolute top-7 bg-white rounded-lg shadow p-2"
                                                :class="{ '-left-24': timeMode == 24, '-left-12': timeMode == 12 }"
                                                x-show="showFromMinutePicker" x-transition
                                                @click.outside="showFromMinutePicker=false">
                                                <div class="w-72">
                                                    <template x-for="minute in minutesFrom" :key="minute.id">
                                                        <div style="width: 10%"
                                                            @click="if (!minute.disabled) { changeMinutesFrom(minute.label); }"
                                                            x-text="minute.label"
                                                            class="float-left px-1 hover:bg-blue-200"
                                                            :class="{
                                                                'cursor-not-allowed opacity-25': minute
                                                                    .disabled,
                                                                'clear-both': minute.id > 0 && minute.id %
                                                                    10 === 0
                                                            }"
                                                            :disabled="minute.disabled"></div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                        <template x-if="timeMode == 12">
                                            <select x-model="meridiemFrom" @change="changeMeridansFrom()"
                                                x-bind:disabled="timePickerDisabled"
                                                :class="{ 'cursor-not-allowed': timePickerDisabled }"
                                                class="focus:outline-none border-none p-0">
                                                <template x-for="meridiem in meridiemsFrom" :key="meridiem.id">
                                                    <option :value="meridiem.value" x-text="meridiem.label"
                                                        :disabled="meridiem.disabled" :selected="meridiem.selected">
                                                    </option>
                                                </template>
                                            </select>
                                        </template>
                                    </div>
                                    <div class="inline-block px-2 h-full">to</div>
                                    <div class="inline-flex items-center h-full px-2 py-1 rounded-r-md bg-white">
                                        <div class="flex flex-col items-center">
                                            <div class="relative">
                                                <input @click="showToHourPicker=true" type="text" value="11"
                                                    x-model="hourToValue"
                                                    :class="{
                                                        'font-bold': showToHourPicker ==
                                                            true,
                                                        'cursor-not-allowed': timePickerDisabled
                                                    }"
                                                    class="focus:outline-none w-6 text-center border-none p-0" readonly
                                                    x-bind:disabled="timePickerDisabled" />
                                                <div class="absolute bg-white rounded-lg shadow p-2"
                                                    x-show="showToHourPicker" x-transition
                                                    @click.outside="showToHourPicker=false">
                                                    <div :class="{ 'w-40': timeMode == 24 }">
                                                        <template x-for="hour in hoursTo" :key="hour.id">
                                                            <div :style="timeMode == 24 && { width: '16.666666%' }"
                                                                @click="if (!hour.disabled) {getHour('to', hour.id);  showToHourPicker=false;}"
                                                                x-text="hour.label" class="px-1 hover:bg-blue-200"
                                                                :class="{
                                                                    'cursor-not-allowed opacity-25': hour
                                                                        .disabled,
                                                                    'float-left': timeMode ==
                                                                        24,
                                                                    'clear-both': timeMode == 24 && hour.id > 0 &&
                                                                        hour.id % 6 === 0
                                                                }"
                                                                :disabled="hour.disabled"></div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inline-block px-1 h-full">:</div>
                                        <div class="relative">
                                            <input @click="showToMinutePicker=true" type="text"
                                                x-model="minuteToValue"
                                                :class="{
                                                    'font-bold': showToMinutePicker ==
                                                        true,
                                                    'cursor-not-allowed': timePickerDisabled
                                                }"
                                                class="focus:outline-none w-6 text-center border-none p-0" readonly
                                                x-bind:disabled="timePickerDisabled" />
                                            <div class="absolute top-7 -right-16 bg-white rounded-lg shadow p-2"
                                                x-show="showToMinutePicker" x-transition
                                                @click.outside="showToMinutePicker=false">
                                                <div class="w-72">
                                                    <template x-for="minute in minutesTo" :key="minute.id">
                                                        <div style="width: 10%"
                                                            @click="if (!minute.disabled) { changeMinutesTo(minute.label); }"
                                                            x-text="minute.label"
                                                            class="float-left px-1 hover:bg-blue-200"
                                                            :class="{
                                                                'cursor-not-allowed opacity-25': minute
                                                                    .disabled,
                                                                'clear-both': minute.id > 0 && minute.id %
                                                                    10 === 0
                                                            }"
                                                            :disabled="minute.disabled"></div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                        <template x-if="timeMode == 12">
                                            <select x-model="meridiemTo" @change="changeMeridansTo()"
                                                x-bind:disabled="timePickerDisabled"
                                                :class="{ 'cursor-not-allowed': timePickerDisabled }"
                                                class="focus:outline-none border-none p-0">
                                                <template x-for="meridiem in meridiemsTo" :key="meridiem.id">
                                                    <option :value="meridiem.value" x-text="meridiem.label"
                                                        :disabled="meridiem.disabled" :selected="meridiem.selected">
                                                    </option>
                                                </template>
                                            </select>
                                        </template>
                                    </div>
                                </div>

                                <div>
                                    <button @click="showDatepicker = false"
                                        class="px-2 py-1 border border-gray-300 hover:border-gray-500 rounded-md">Cancel</button>
                                    <button @click="outputDateValues(); showDatepicker = false"
                                        class="px-2 py-1 border border-blue-600 bg-blue-500 hover:bg-blue-300 text-white rounded-md">OK</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
