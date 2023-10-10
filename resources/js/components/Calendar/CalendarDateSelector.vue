<template>
  <div class="calendar-date-selector-form">
    <div class="grid grid-cols-2 gap-4">
      <div class="calendar-date-indicator">
      {{ monthLabels[selectedMonth-1] }} {{selectedYear}}
      </div>
      <div class="calendar-date-picker">
        <select v-model="selectedMonth" @change="goToYearAndMonth">
          <option v-for="month in months" :value="month" :selected="month == selectedMonth">{{ monthLabels[month-1] }}</option>
        </select>
        <select v-model="selectedYear" @change="goToYearAndMonth">
          <option v-for="year in years" :value="year" :selected="year == selectedYear">{{ year }}</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import dayjs from "dayjs";
import { trans } from 'laravel-vue-i18n';

export default {
  name: "CalendarModeSelector",

  props: {
    currentDate: {
      type: String,
      required: true
    },

    selectedDate: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      years: [],
      months: [],
      monthLabels: [
        trans('calendar.month_jan'), 
        trans('calendar.month_feb'), 
        trans('calendar.month_mar'),
        trans('calendar.month_apr'), 
        trans('calendar.month_may'),
        trans('calendar.month_jun'),
        trans('calendar.month_jul'),
        trans('calendar.month_aug'),
        trans('calendar.month_sep'),
        trans('calendar.month_oct'),
        trans('calendar.month_nov'),
        trans('calendar.month_dec'),         
      ],
      currentYear: '',
      currentMonth: '',
      selectedYear: '',
      selectedMonth: ''
    };
  },

  methods: {
    goToYearAndMonth() {
      let newSelectedDate = dayjs(this.selectedYear + '-' + this.selectedMonth + '-01');
      this.$emit("dateSelected", newSelectedDate);
    }
  },

  mounted() {
    //Generate the years for the dropdown
    this.currentYear = parseInt(dayjs(this.selectedDate).format('YYYY')); //2023
    for(let i = (this.currentYear - 10); i <= this.currentYear; i++){
      this.years.push(i);
    }

    //Generate the months for the dropdown
    this.currentMonth =  parseInt(dayjs(this.selectedDate).format('DD')); //10
    for(let m = 1; m <= 12; m++){
      this.months.push(m);
    }

    this.selectedYear = this.currentYear;
    this.selectedMonth = this.currentMonth;
  }
};
</script>

<style scoped>
.calendar-date-selector {
  display: flex;
  justify-content: space-between;
  width: 80px;
  color: var(--grey-800);
}

.calendar-date-selector > * {
  cursor: pointer;
  user-select: none;
}
.calendar-date-selector-form {
  padding:1.5em;
}
.calendar-date-indicator {
  font-size: 24px;
  color: var(--grey-00);
}
.calendar-date-picker {
  text-align: right;
}
.calendar-date-picker select {
  padding: 4px;
  margin-right:10px;
  background-color:white;
  border-radius:5px;
}
</style>

