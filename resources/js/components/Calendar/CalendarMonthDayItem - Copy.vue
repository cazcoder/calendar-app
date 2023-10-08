<template>
  <li
    @click="shouldShowModal(props.day.isCurrentMonth, props.day.date)"
    
    class="calendar-day"
    :class="{
      'calendar-day--not-current': !props.day.isCurrentMonth,
      'calendar-day--today': props.isToday
    }"
  >
    <span>{{ dayLabel }}</span>
  </li>
</template>

<script setup>
import dayjs from "dayjs";
import { computed } from 'vue'

let props = defineProps({
    day: {
      type: Object,
      required: true
    },

    isCurrentMonth: {
      type: Boolean,
      default: false
    },

    isToday: {
      type: Boolean,
      default: false
    }
})

const dayLabel = computed(() => {
  return dayjs(props.day.date).format("D");
})

function shouldShowModal(dayInCurrentMonth, clickedDay) {
  if(dayInCurrentMonth){
    emit('clickedDay', clickedDay);
  }
}
//console.log(day);
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
  right: 50%;
  width: var(--day-label-size);
  height: var(--day-label-size);
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
</style>

