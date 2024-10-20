export default () => ({
    showDatepicker: false,
    showFromHourPicker: false,
    showToHourPicker: false,
    showFromMinutePicker: false,
    showToMinutePicker: false,
    timePickerDisabled: true,
    dateFromYmdHis: "",
    dateToYmdHis: "",
    outputDateFromValue: "",
    outputDateToValue: "",
    currentDate: null,
    dateFrom: null,
    dateTo: null,
    endToShow: "",
    timeMode: 12,
    hourFromValue: 12,
    hourToValue: 11,
    hour24FromValue: 0,
    hour24ToValue: 23,
    meridiemFrom: "am",
    meridiemTo: "pm",
    minuteFromValue: "00",
    minuteToValue: "59",
    selecting: false,
    month: "",
    year: "",
    no_of_days: [],
    blankdays: [],
    hoursFrom: [],
    hoursTo: [],
    minutesFrom: [],
    minutesTo: [],
    meridiemsFrom: [],
    meridiemsTo: [],
    MONTH_NAMES: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ],
    DAYS: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],

    convertFromYmd(dateYmd) {
        const year = Number(dateYmd.substr(0, 4));
        const month = Number(dateYmd.substr(5, 2)) - 1;
        const date = Number(dateYmd.substr(8, 2));

        return new Date(year, month, date);
    },

    convertToYmd(dateObject) {
        const year = dateObject.getFullYear();
        const month = dateObject.getMonth() + 1;
        const date = dateObject.getDate();

        return (
            year + "-" + ("0" + month).slice(-2) + "-" + ("0" + date).slice(-2)
        );
    },

    init() {
        if (!this.dateFrom) {
            if (this.dateFromYmd) {
                this.dateFrom = this.convertFromYmd(this.dateFromYmd);
            }
        }
        if (!this.dateTo) {
            if (this.dateToYmd) {
                this.dateTo = this.convertFromYmd(this.dateToYmd);
            }
        }
        if (!this.dateFrom) {
            this.dateFrom = this.dateTo;
        }
        if (!this.dateTo) {
            this.dateTo = this.dateFrom;
        }
        if (this.endToShow === "from" && this.dateFrom) {
            this.currentDate = this.dateFrom;
        } else if (this.endToShow === "to" && this.dateTo) {
            this.currentDate = this.dateTo;
        } else {
            this.currentDate = new Date();
        }
        const currentMonth = this.currentDate.getMonth();
        const currentYear = this.currentDate.getFullYear();
        if (this.month !== currentMonth || this.year !== currentYear) {
            this.month = currentMonth;
            this.year = currentYear;
            this.getNoOfDays();
        }
        this.setDateValues();
        this.getMeridansFrom();
        this.getMeridansTo();

        // Livewire.on("updateOutputDateFromValue", (newValue) => {
        //     this.outputDateFromValue = this.formatDateTime(
        //         new Date(Date.parse(newValue[0])),
        //         this.meridiemFrom
        //     );
        // });

        // Livewire.on("updateOutputDateToValue", (newValue) => {
        //     this.outputDateToValue = this.formatDateTime(
        //         new Date(Date.parse(newValue[0])),
        //         this.meridiemTo
        //     );
        // });
    },

    changeTimeMode() {
        if (this.timeMode == 12) {
            let hourFrom = this.hour24FromValue;
            if (hourFrom === 0) {
                hourFrom = 12;
            } else if (hourFrom > 12) {
                hourFrom = hourFrom - 12;
            }
            let hourTo = this.hour24ToValue;
            if (hourTo === 0) {
                hourTo = 12;
            } else if (hourTo > 12) {
                hourTo = hourTo - 12;
            }
            this.meridiemFrom = this.hour24FromValue > 11 ? "pm" : "am";
            this.meridiemTo = this.hour24ToValue > 11 ? "pm" : "am";
            this.getHour("from", hourFrom);
            this.getHour("to", hourTo);
        } else {
            this.getHour("from", this.hour24FromValue);
            this.getHour("to", this.hour24ToValue);
        }
    },

    isToday(date) {
        const today = new Date();
        const d = new Date(this.year, this.month, date);

        return today.toDateString() === d.toDateString();
    },

    isDateFrom(date) {
        const d = new Date(this.year, this.month, date);

        if (!this.dateFrom) {
            return false;
        }

        return d.getTime() === this.dateFrom.getTime();
    },

    isDateTo(date) {
        const d = new Date(this.year, this.month, date);

        if (!this.dateTo) {
            return false;
        }

        return d.getTime() === this.dateTo.getTime();
    },

    isSingleDay() {
        if (!this.dateFrom || !this.dateTo) {
            return false;
        }
        return this.dateFrom.getTime() === this.dateTo.getTime();
    },

    isInRange(date) {
        const d = new Date(this.year, this.month, date);

        return d > this.dateFrom && d < this.dateTo;
    },

    isDisabledFromHour(hour) {
        let hour24 = hour;
        if (this.timeMode == 12) {
            if (hour === 12 && this.meridiemFrom === "am") {
                hour24 = 0;
            } else if (hour < 12 && this.meridiemFrom === "pm") {
                hour24 = hour + 12;
            }
        }
        if (this.isSingleDay() && hour24 > this.hour24ToValue) {
            return true;
        }
        return false;
    },

    isDisabledToHour(hour) {
        let hour24 = hour;
        if (this.timeMode == 12) {
            if (hour === 12 && this.meridiemTo === "am") {
                hour24 = 0;
            } else if (hour < 12 && this.meridiemTo === "pm") {
                hour24 = hour + 12;
            }
        }
        if (this.isSingleDay() && hour24 < this.hour24FromValue) {
            return true;
        }
        return false;
    },

    outputDateValues() {
        if (this.dateFrom) {
            const timeFromString = this.getTimeString("from");
            const dateFromString = this.convertToYmd(this.dateFrom);
            const dateTimeFrom = new Date(
                dateFromString + "T" + timeFromString
            );
            this.outputDateFromValue = this.formatDateTime(
                dateTimeFrom,
                this.meridiemFrom
            );
            this.dateFromYmdHis = dateFromString + " " + timeFromString;
        }
        if (this.dateTo) {
            const timeToString = this.getTimeString("to");
            const dateToString = this.convertToYmd(this.dateTo);
            const dateTimeTo = new Date(dateToString + "T" + timeToString);
            this.outputDateToValue = this.formatDateTime(
                dateTimeTo,
                this.meridiemTo
            );
            this.dateToYmdHis = dateToString + " " + timeToString;
        }
        this.endToShow = "";

        this.$wire.dispatch("shop-date-changed", {
            from: this.dateFrom.toISOString(),
            to: this.dateTo.toISOString(),
        });

        console.log("df", this.dateFrom.toISOString());
        console.log("dt", this.dateTo.toISOString());
    },

    formatDateTime(dateTime, meridiem) {
        const day = dateTime.getDate().toString().padStart(2, "0");
        const month = (dateTime.getMonth() + 1).toString().padStart(2, "0"); // Add 1 because months are zero-indexed
        const year = dateTime.getFullYear();

        let hour = dateTime.getHours();
        let hourString;
        if (this.timeMode == 12) {
            if (meridiem === "am" && hour === 0) {
                hour = 12;
            } else if (meridiem === "pm" && hour > 12) {
                hour = hour - 12;
            }
            hourString = hour.toString();
            meridiem = " " + meridiem;
        } else {
            hourString = hour.toString().padStart(2, "0");
            meridiem = "";
        }
        const minute = dateTime.getMinutes().toString().padStart(2, "0");
        //const second  = dateTime.getSeconds().toString().padStart(2, '0');

        // Return the formatted date string as DD.MM.YYYY
        return `${day}.${month}.${year}`;
    },

    getTimeString(end) {
        const hour = end === "from" ? this.hour24FromValue : this.hour24ToValue;
        const minute =
            end === "from" ? this.minuteFromValue : this.minuteToValue;
        const second = end === "from" ? "00" : "59";
        return hour.toString().padStart(2, "0") + ":" + minute + ":" + second;
    },

    getHour(end, hour) {
        let hour24 = hour;
        if (this.timeMode == 12) {
            const meridan =
                end === "from" ? this.meridiemFrom : this.meridiemTo;
            if (hour === 12 && meridan === "am") {
                hour24 = 0;
            } else if (hour < 12 && meridan === "pm") {
                hour24 = hour + 12;
            }
        }
        if (end === "from") {
            this.hourFromValue = this.timeMode == 12 ? hour : hour24;
            this.hour24FromValue = hour24;
            this.getHoursTo();
        } else {
            this.hourToValue = this.timeMode == 12 ? hour : hour24;
            this.hour24ToValue = hour24;
            this.getHoursFrom();
        }
        this.getMinutesFrom();
        this.getMinutesTo();
        this.getMeridansFrom();
        this.getMeridansTo();
    },

    setDateValues() {
        if (this.dateFrom) {
            const dateFromString = this.convertToYmd(this.dateFrom);
            const dateFrom = new Date(dateFromString);
        }
        if (this.dateTo) {
            const dateToString = this.convertToYmd(this.dateTo);
            const dateTo = new Date(dateToString);
        }
    },

    getDateValue(date, temp) {
        // if we are in mouse over mode but have not started selecting a range, there is nothing more to do.
        if (temp && !this.selecting) {
            return;
        }
        let selectedDate = new Date(this.year, this.month, date);
        if (this.endToShow === "from") {
            this.dateFrom = selectedDate;
            if (!this.dateTo) {
                this.dateTo = selectedDate;
            } else if (selectedDate > this.dateTo) {
                this.endToShow = "to";
                this.dateFrom = this.dateTo;
                this.dateTo = selectedDate;
            }
        } else if (this.endToShow === "to") {
            this.dateTo = selectedDate;
            if (!this.dateFrom) {
                this.dateFrom = selectedDate;
            } else if (selectedDate < this.dateFrom) {
                this.endToShow = "from";
                this.dateTo = this.dateFrom;
                this.dateFrom = selectedDate;
            }
        }
        this.setDateValues();

        this.timePickerDisabled = !this.dateFrom;

        if (!this.timePickerDisabled) {
            /* If a time tange has already been set with the from time > to time and date range is now for a single day, reset the time the range */
            if (
                !temp &&
                this.isSingleDay() &&
                parseInt(this.hour24FromValue + "" + this.minuteFromValue) >
                    parseInt(this.hour24ToValue + "" + this.minuteToValue)
            ) {
                this.hourFromValue = this.timeMode == 12 ? 12 : 0;
                this.hourToValue = this.timeMode == 12 ? 11 : 23;
                this.hour24FromValue = 0;
                this.hour24ToValue = 23;
                this.meridiemFrom = "am";
                this.meridiemTo = "pm";
                this.minuteFromValue = "00";
                this.minuteToValue = "59";
            }
            this.getHoursFrom();
            this.getHoursTo();
            this.getMinutesFrom();
            this.getMinutesTo();
            this.getMeridansFrom();
            this.getMeridansTo();
        }

        if (!temp) {
            this.selecting = !this.selecting;
        }
    },

    getNoOfDays() {
        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

        // find where to start calendar day of week
        let dayOfWeek = new Date(this.year, this.month, 1).getDay() - 1;
        if (dayOfWeek < 0) {
            dayOfWeek = 6; // Adjust if dayOfWeek is Sunday (should be 6 instead of -1)
        }
        let blankdaysArray = [];
        for (var i = 0; i < dayOfWeek; i++) {
            blankdaysArray.push(i);
        }

        let daysArray = [];
        for (var i = 1; i <= daysInMonth; i++) {
            daysArray.push(i);
        }

        this.blankdays = blankdaysArray;
        this.no_of_days = daysArray;
    },

    getHoursFrom() {
        this.hoursFrom = [];
        for (let i = 0; i < this.timeMode; i++) {
            let value = this.timeMode == 12 && i === 0 ? 12 : i;
            let hour = new Object();
            hour.id = value;
            hour.label =
                this.timeMode == 12 ? value : i.toString().padStart(2, "0");
            hour.disabled = this.isDisabledFromHour(value);
            this.hoursFrom.push(hour);
        }
    },

    getHoursTo() {
        this.hoursTo = [];
        for (let i = 0; i < this.timeMode; i++) {
            let value = this.timeMode == 12 && i === 0 ? 12 : i;
            let hour = new Object();
            hour.id = value;
            hour.label =
                this.timeMode == 12 ? value : i.toString().padStart(2, "0");
            hour.disabled = this.isDisabledToHour(value);
            this.hoursTo.push(hour);
        }
    },

    changeMinutesFrom(minute) {
        this.minuteFromValue = minute;
        this.showFromMinutePicker = false;
        this.getMinutesTo();
    },

    changeMinutesTo(minute) {
        this.minuteToValue = minute;
        this.showToMinutePicker = false;
        this.getMinutesFrom();
    },

    getMinutesFrom() {
        this.minutesFrom = [];
        for (let i = 0; i < 60; i++) {
            let minute = new Object();
            minute.id = i;
            minute.label = i.toString().padStart(2, "0");
            minute.disabled =
                this.isSingleDay() &&
                this.hour24FromValue === this.hour24ToValue &&
                minute.label > this.minuteToValue;
            this.minutesFrom.push(minute);
        }
    },

    getMinutesTo() {
        this.minutesTo = [];
        for (let i = 0; i < 60; i++) {
            let minute = new Object();
            minute.id = i;
            minute.label = i.toString().padStart(2, "0");
            minute.disabled =
                this.isSingleDay() &&
                this.hour24FromValue === this.hour24ToValue &&
                this.minuteFromValue > minute.label;
            this.minutesTo.push(minute);
        }
    },

    changeMeridansFrom() {
        this.getHour("from", this.hourFromValue);
        this.getHoursFrom();
        this.getHoursTo();
        this.getMinutesFrom();
        this.getMinutesTo();
        this.getMeridansTo();
    },

    changeMeridansTo() {
        this.getHour("to", this.hourToValue);
        this.getHoursFrom();
        this.getHoursTo();
        this.getMinutesFrom();
        this.getMinutesTo();
        this.getMeridansFrom();
    },

    getMeridansFrom() {
        this.meridiemsFrom = [];
        let meridiemAM = new Object();
        meridiemAM.id = 1;
        meridiemAM.value = "am";
        meridiemAM.label = "AM";
        meridiemAM.disabled = false;
        meridiemAM.selected = this.meridiemFrom === "am";
        let meridiemPM = new Object();
        meridiemPM.id = 2;
        meridiemPM.value = "pm";
        meridiemPM.label = "PM";
        meridiemPM.disabled =
            this.isSingleDay() &&
            (this.meridiemTo === "am" ||
                this.hour24FromValue > this.hour24ToValue);
        meridiemPM.selected = this.meridiemFrom === "pm";
        this.meridiemsFrom.push(meridiemAM);
        this.meridiemsFrom.push(meridiemPM);
    },

    getMeridansTo() {
        this.meridiemsTo = [];
        let meridiemAM = new Object();
        meridiemAM.id = 1;
        meridiemAM.value = "am";
        meridiemAM.label = "AM";
        meridiemAM.disabled =
            this.isSingleDay() &&
            (this.meridiemFrom === "pm" ||
                this.hour24FromValue > this.hour24ToValue);
        meridiemAM.selected = this.meridiemTo === "am";
        let meridiemPM = new Object();
        meridiemPM.id = 2;
        meridiemPM.value = "pm";
        meridiemPM.label = "PM";
        meridiemPM.disabled = false;
        meridiemPM.selected = this.meridiemTo === "pm";
        this.meridiemsTo.push(meridiemAM);
        this.meridiemsTo.push(meridiemPM);
    },

    closeDatepicker() {
        this.endToShow = "";
        this.showDatepicker = false;
    },
});
