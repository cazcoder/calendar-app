<script setup>
import CalendarMonth from "../components/Calendar/CalendarMonth.vue";

</script>

<template>
  
    <CalendarMonth />

  
</template>

<style>
body {
  font-weight: 100;
  --grey-100: #e4e9f0;
  --grey-200: #cfd7e3;
  --grey-300: #b5c0cd;
  --grey-800: #3e4e63;
  --grid-gap: 1px;
  --day-label-size: 20px;
}

.calendar-month-header {
  display: flex;
  justify-content: space-between;
  background-color: #fff;
  padding: 10px;
}
</style>