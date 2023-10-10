<template>
  <Toast />

    <div class="flex flex-wrap my-6 -mx-3">
      <div v-if="legend.length > 0" class="w-full max-w-full px-3 md:w-1/2 md:flex-none lg:w-1/3 lg:flex-none">
      <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
       
       
        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
          <h6>{{ $t('calendar.countries_visited') }}</h6>
        </div>
        <div class="flex-auto p-4">
          <div >
            
            
              <div v-for="country in legend" class="relative mb-4 mt-0 after:clear-both after:table after:content-['']">
                <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                  <CountryFlag :tooltip="country.name" :code="country.code" />
                  <!--<span class="country-color" :style="{ backgroundColor: country.color }"></span>-->
                </span>
                <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                 <h6 class="mb-0 font-semibold leading-normal text-sm text-slate-700">{{ country.name}}</h6>
                </div>
              </div>
            
          
            </div>

          </div>
        </div>

     </div> 


     <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 md:flex-none lg:flex-none" :class="{ 'md:w-1/2': legend.length > 0, 'lg:w-2/3': legend.length > 0 }">
      <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
      

       <div class="calendar-month">

        <div>
        <CalendarDateSelector
        :current-date="today"
        :selected-date="selectedDate"
        @dateSelected="selectDate"
      />
      </div>
    
    <CalendarWeekdays/>

    <ol class="days-grid">
      <li v-for="(day, index) in days"
        @click="showModal(day.isCurrentMonth, day.date, index)"
        class="calendar-day"
        :class="{
          'calendar-day--not-current': !day.isCurrentMonth,
          'calendar-day--today': day.date === today
        }">

      <span>{{ getDay(day.date) }} </span>
      <div class="dayColors" v-if="day.isCurrentMonth">
        <CountryFlag :tooltip="getCountryTooltip(code)" v-for="code in monthColors[getDay(day.date)]" :code="code"/>
        
      </div>
      </li>
    </ol>

  </div>

  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
          <div class="fixed inset-0 w-screen overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4">
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
              {{ $t('calendar.modal_header') }}
              </DialogTitle>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  {{ $t('calendar.modal_text') }}
                  
                  <input readonly type="text" :value="$t('calendar.modal_selected_date') + '&nbsp;' + clickedDay" class="mt-2 mb-2 focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-grey-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                
                  <CountryMultiSelect @selectedCountryItem="selectedCountryItemOption"></CountryMultiSelect>
              
                </p>
              </div>

              <div class="mt-4">
                <button @click="saveCountries" type="button" class="inline-block px-6 py-3 mr-3 font-bold text-center uppercase align-middle transition-all bg-transparent border rounded-lg cursor-pointer border-fuchsia-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs text-fuchsia-500">{{ $t('calendar.modal_savebtn') }}</button>
                <button @click="closeModal" type="button" class="ml-1 nline-block px-6 py-3 mr-3 font-bold text-center uppercase align-middle transition-all bg-transparent border rounded-lg cursor-pointer border-fuchsia-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs text-fuchsia-500">{{ $t('calendar.modal_closebtn') }}</button>
              </div>
            </DialogPanel>

            </div>
            </div>

          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
 
      </div>
     </div>

    
    </div>

</template>

<script>
import dayjs from "dayjs";
import weekday from "dayjs/plugin/weekday";
import weekOfYear from "dayjs/plugin/weekOfYear";
import CalendarDateSelector from "./CalendarDateSelector.vue";
import CalendarWeekdays from "./CalendarWeekdays.vue";
import CountryFlag from "../CountryFlag.vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { MultiSelect } from "vue-search-select"
import CountryMultiSelect from '../Form/CountryMultiSelect.vue'
import { useCountryStore }  from '../../store/country'
import Toast from '../Toast.vue'
import { reactive } from 'vue'
const countryStore = useCountryStore()

dayjs.extend(weekday);
dayjs.extend(weekOfYear);

export default {
  name: "CalendarMonth",

  components: {
    CalendarDateSelector,
    CalendarWeekdays,
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
    MultiSelect,
    CountryMultiSelect,
    CountryFlag,
    Toast
  },

  data() {
    return {
      selectedDate: dayjs(), 
      isOpen: false,
      selectedCountries: [], //Stores the countries selected in the modal
      modalCountries: [],       //A list of all countries (ideally should exclude the ones already assigned)
      modalSavedCountries: [], //Stores the countries saved in the db for a given data
      clickedDay: null,
      legend: [],
      monthColors: [],
      tooltips: []
    };
  },

  computed: {
    
    days() {
      return [
        ...this.previousMonthDays,
        ...this.currentMonthDays,
        ...this.nextMonthDays
      ];
    },

    today() {
      return dayjs().format("YYYY-MM-DD");
    },

    month() {
      return Number(this.selectedDate.format("M"));
    },

    year() {
      return Number(this.selectedDate.format("YYYY"));
    },

    numberOfDaysInMonth() {
      return dayjs(this.selectedDate).daysInMonth();
    },

    currentMonthDays() {
      return [...Array(this.numberOfDaysInMonth)].map((day, index) => {
        return {
          date: dayjs(`${this.year}-${this.month}-${index + 1}`).format(
            "YYYY-MM-DD"
          ),
          isCurrentMonth: true
        };
      });
    },

    previousMonthDays() {
      const firstDayOfTheMonthWeekday = this.getWeekday(
        this.currentMonthDays[0].date
      );
      const previousMonth = dayjs(`${this.year}-${this.month}-01`).subtract(
        1,
        "month"
      );

      // Cover first day of the month being sunday (firstDayOfTheMonthWeekday === 0)
      const visibleNumberOfDaysFromPreviousMonth = firstDayOfTheMonthWeekday
        ? firstDayOfTheMonthWeekday - 1
        : 6;

      const previousMonthLastMondayDayOfMonth = dayjs(
        this.currentMonthDays[0].date
      )
        .subtract(visibleNumberOfDaysFromPreviousMonth, "day")
        .date();

      return [...Array(visibleNumberOfDaysFromPreviousMonth)].map(
        (day, index) => {
          return {
            date: dayjs(
              `${previousMonth.year()}-${previousMonth.month() +
                1}-${previousMonthLastMondayDayOfMonth + index}`
            ).format("YYYY-MM-DD"),
            isCurrentMonth: false
          };
        }
      );
    },

    nextMonthDays() {
      const lastDayOfTheMonthWeekday = this.getWeekday(
        `${this.year}-${this.month}-${this.currentMonthDays.length}`
      );

      const nextMonth = dayjs(`${this.year}-${this.month}-01`).add(1, "month");

      const visibleNumberOfDaysFromNextMonth = lastDayOfTheMonthWeekday
        ? 7 - lastDayOfTheMonthWeekday
        : lastDayOfTheMonthWeekday;

      return [...Array(visibleNumberOfDaysFromNextMonth)].map((day, index) => {
        return {
          date: dayjs(
            `${nextMonth.year()}-${nextMonth.month() + 1}-${index + 1}`
          ).format("YYYY-MM-DD"),
          isCurrentMonth: false
        };
      });
    }
  },

  methods: {

    getCountryTooltip(code){ 
      return this.tooltips[code.toLowerCase()];
    },

    getDay(date) {
      return dayjs(date).format('D');
    },

    getWeekday(date) {
      return dayjs(date).weekday();
    },

    selectDate(newSelectedDate) {  
      this.selectedDate = newSelectedDate; 
      this.updateCalendar();
    },

    showModal(dayInCurrentMonth, clickedDay) {
      if(dayInCurrentMonth){ 
        this.isOpen = true;
        this.clickedDay = clickedDay;
        countryStore.clickedDay = clickedDay;
        this.selectedCountries = []; 
      }
      
    },

    //Called when a country is chosen in the dropdown
    selectedCountryItemOption(items) { //console.log(items.length);
      this.selectedCountries = items;
    },

    async saveCountries() {
      this.isOpen = false;
      let countryArray = [];
      for (let country of this.selectedCountries) {
        countryArray.push(country.value);
      }
      //alert(countryArray.length);
      //If there is no selections/deletions nothing has changed so ignore
      //if(countryArray.length > 0){
       
        await countryStore.saveModalData(this.clickedDay, countryArray); 

        this.legend = countryStore.legend; 
        this.monthColors = countryStore.monthColors; 
       
      //} else {
        //alert('Testing');
      //}
    },

    closeModal() {
      this.isOpen = false;
      this.selectedCountries = []; 
    },

    async updateCalendar(){ 
      let selectedYear = dayjs(this.selectedDate).format('YYYY');
      let selectedMonth = dayjs(this.selectedDate).format('M'); 
      await countryStore.fetchLegendAndMonthColors(selectedYear, selectedMonth); 
      this.legend = countryStore.legend;
      this.monthColors = countryStore.monthColors;
      this.tooltips = countryStore.tooltips;
    }
  },

  created(){
    this.updateCalendar();
	}
};
</script>

<style scoped>

.calendar-month {
  position: relative;
  background-color: var(--grey-200);
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}

.day-of-week {
  color: var(--grey-800);
  font-size: 18px;
  background-color: #fff;
  padding-bottom: 5px;
  padding-top: 10px;
}

.day-of-week,
.days-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}

.day-of-week > * {
  text-align: center;
  padding-right: 5px;
}

.days-grid {
  height: 100%;
  position: relative;
  grid-column-gap: var(--grid-gap);
  grid-row-gap: var(--grid-gap);
  border-top: solid 1px var(--grey-200);
}
.country-color {
  width:30px;
  height:30px;
  
}

/* DAYS OF MONTH */
.calendar-day {
  position: relative;
  min-height: 100px;
  font-size: 16px;
  background-color: #fff;
  color: var(--grey-800);
  padding: 5px;
}

.calendar-day > span {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  right: 2px;
  width: var(--day-label-size);
  height: var(--day-label-size);
  right: 50%;
}

.calendar-day--not-current {
  background-color: #f5f7fa;
  color: var(--grey-300);
}

.calendar-day--today {
  padding-top: 4px;
}

.calendar-day--today > span {
  color: #fff;
  border-radius: 9999px;
  background-color: var(--grey-800);
}
.dayColors {
  display:flex;
  margin-top:50%;
  /*border:1px solid red;*/
  justify-content: center;
  align-content: stretch;
}
.dayColors div {
  width:10px;
  height:10px;
  justify-content: space-between;
  margin: 2px; 
  border-radius:4px; 
}
</style>

