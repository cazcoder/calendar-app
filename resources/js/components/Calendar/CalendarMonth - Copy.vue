<template>
  <Toast />

 

    <div class="flex flex-wrap my-6 -mx-3">
      <div v-if="legend.length > 0" class="w-full max-w-full px-3 md:w-1/2 md:flex-none lg:w-1/3 lg:flex-none">
      <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
       
       
        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
          <h6>Countries visited.</h6>
        </div>
        <div class="flex-auto p-4">
          <div class="before:border-r-solid relative before:absolute before:top-0 before:left-4 before:h-full before:border-r-2 before:border-r-slate-100 before:content-[''] before:lg:-ml-px">
            
            
              <div v-for="country in legend" class="relative mb-4 mt-0 after:clear-both after:table after:content-['']">
                <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                  <span class="country-color" :style="{ backgroundColor: country.color }"></span>
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
    <div class="calendar-month-header">
      <CalendarDateIndicator
        :selected-date="selectedDate"
        class="calendar-month-header-selected-month"
      />

      <CalendarDateSelector
        :current-date="today"
        :selected-date="selectedDate"
        @dateSelected="selectDate"
      />
    </div>

    <CalendarWeekdays/>

    <ol class="days-grid">
      <CalendarMonthDayItem
        v-for="day in days"
        :key="day.date"
        :day="day"
        :is-today="day.date === today"
        @clicked-day="openModal"
        ref="dayitem"
      />
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
                Assign Countries
              </DialogTitle>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  Please choose from the countries below. Type in a country name to filter the results.
                  
                  <input id="modalClickedDay" type="hidden" :value="clickedDay">
                  <input type="text" :value="$t('calendar.modal_selected_date') + '&nbsp;' + clickedDay" class="mt-2 mb-2 focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-grey-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                
                  <CountryMultiSelect @selectedCountryItem="selectedCountryItemOption"></CountryMultiSelect>
              
                </p>
              </div>

              <div class="mt-4">
                <button @click="assignCountries" type="button" class="inline-block px-6 py-3 mr-3 font-bold text-center uppercase align-middle transition-all bg-transparent border rounded-lg cursor-pointer border-fuchsia-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs text-fuchsia-500">Assign</button>
                <button @click="closeModal" type="button" class="ml-1 nline-block px-6 py-3 mr-3 font-bold text-center uppercase align-middle transition-all bg-transparent border rounded-lg cursor-pointer border-fuchsia-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs text-fuchsia-500">Close</button>
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
import CalendarMonthDayItem from "./CalendarMonthDayItem.vue";
import CalendarDateIndicator from "./CalendarDateIndicator.vue";
import CalendarDateSelector from "./CalendarDateSelector.vue";
import CalendarWeekdays from "./CalendarWeekdays.vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { MultiSelect } from "vue-search-select"
import CountryMultiSelect from '../CountryMultiSelect.vue'
import { useCountryStore }  from '../../store/country'
import Toast from '../Toast.vue'
const countryStore = useCountryStore()

dayjs.extend(weekday);
dayjs.extend(weekOfYear);

export default {
  name: "CalendarMonth",

  components: {
    CalendarMonthDayItem,
    CalendarDateIndicator,
    CalendarDateSelector,
    CalendarWeekdays,
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
    MultiSelect,
    CountryMultiSelect,
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
      test: []
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

    getDay(day){
      let $formatted = dayjs(day.date).format('D');
      return $formatted;
    },

    getWeekday(date) {
      return dayjs(date).weekday();
    },

    selectDate(newSelectedDate) {  
      this.selectedDate = newSelectedDate; 
      this.updateCalendar();
    },

    async openModal(clickedDay) { 
      this.isOpen = true;
      this.clickedDay = clickedDay;
      countryStore.clickedDay = clickedDay;
      this.selectedCountries = [];
    },

    async assignCountries() {
      this.isOpen = false;
      let countryArray = [];
      for (let country of this.selectedCountries) {
        countryArray.push(country.value);
      }
      
      //If there is no selections/deletions nothing has changed so ignore
      if(countryArray.length > 0){
        await countryStore.saveModalData(this.clickedDay, countryArray); 

        let day = dayjs(this.clickedDay).format('D') - 1; //Js array begin at 0 
        this.legend = countryStore.legend; 
        //this.$refs.dayitem[day].updateCountryColors(countryStore.dayColors);
      }
    },

    closeModal() {
      this.isOpen = false;
      this.selectedCountries = []; 
    },

    //Called when a country is chosen in the dropdown
    selectedCountryItemOption(items) { //console.log(items.length);
      this.selectedCountries = items;
    },

    async updateCalendar(){ 
      let selectedYear = dayjs(this.selectedDate).format('YYYY');
      let selectedMonth = dayjs(this.selectedDate).format('M'); //alert(selectedYear + '-' + selectedMonth);
      await countryStore.fetchLegendAndMonthColors(selectedYear, selectedMonth); 
      this.legend = countryStore.legend;
      //console.log(countryStore.monthColors.length);
      //alert(this.legend.length);
      //this.monthColors = countryStore.monthColors; //console.log(this.test);
      //let monthColors = countryStore.monthColors;  
      
      //this.$refs.dayitem[5].updateCountryColors(monthColors[5]);
      //this.$refs.dayitem[5].updateText('great');
      //console.log(this.$refs.dayitem[5]);

    }
  },

  created(){
    //let date = new Date();
	  //let current_time = date.getHours()+":"+date.getMinutes()+":"+ date.getSeconds();
    //console.log('Fetching calendar information - ' + current_time);
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
  text-align: right;
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
</style>

