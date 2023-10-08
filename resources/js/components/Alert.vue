<script setup>
let props = defineProps(['text', 'color'])
let colors = ['slate', 'lime', 'cyan', 'red', 'fuchsia'];
let color = 'bg-' + colors[colors.indexOf(props.color)] + '-500'; 
</script>

<template>
  <div class="relative w-full p-4 text-white rounded-lg" :class="color">{{ text }}</div>
</template>

