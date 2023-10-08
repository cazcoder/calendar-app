<template>
  <li
    @click="shouldShowModal(day.isCurrentMonth, day.date)"
    class="calendar-day"
    :class="{
      'calendar-day--not-current': !day.isCurrentMonth,
      'calendar-day--today': isToday
    }"
  >
    <span>{{ label }}</span>
    <div class="dayColors" v-if="day.isCurrentMonth">
     <div v-for="color in dayColors" :style="{ backgroundColor: color }">tes</div>
    </div>
    {{ text }}
    <button @click="updateText">UP</button>
  </li> 
</template>

<script>
import dayjs from "dayjs"
import { useCountryStore }  from '../../store/country'
import { storeToRefs } from 'pinia';
import { watch } from 'vue'

const countryStore = useCountryStore()


export default {
  name: "CalendarMonthDayItem",

  props: {
    day: {
      type: Object,
      required: true
    },

    /*dayColors: {
      type: Array,
    },*/

    isCurrentMonth: {
      type: Boolean,
      default: false
    },

    isToday: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      dayColors: [],
      text: 'Machine'
    }
  },

  computed: {
    label() {
      return dayjs(this.day.date).format("D");
    }
  },

  methods: {
    shouldShowModal(dayInCurrentMonth, clickedDay) {
      if(dayInCurrentMonth){
        this.$emit('clickedDay', clickedDay);
      }
    },

    updateCountryColors(dayColors){
      //console.log('more progress');
      this.dayColors = ref(dayColors);
      console.log(this.dayColors.length);
    },

    updateText(){//alert('being called');
      this.text = 'Working';
    }

  }, 

  created() {
    //let date = new Date();
	  //let current_time = date.getHours()+":"+date.getMinutes()+":"+ date.getSeconds();
    //console.log('Showing calendar information - ' + current_time);
    //alert(countryStore.monthColors.length);
  },

  mounted() {
    //this.text = 'Puppy';
  }

};
</script>

<style scoped>
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
  background-color: var(--grey-100);
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


