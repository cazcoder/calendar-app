<script setup>
let props = defineProps(['code', 'tooltip'])
</script>

<template>
  <img :data-tippy-content="tooltip" class="mr-2 countryFlag" style="display:inline;" :src="'img/flags/24x24/' + code.toLowerCase() + '.png'">
</template>

