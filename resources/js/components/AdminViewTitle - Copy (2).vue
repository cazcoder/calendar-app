<script setup>
import { onMounted } from 'vue'
let props = defineProps(['text'])
const emit = defineEmits(['counterIncremented'])
emit('counterIncremented', 'Testing');

/*const handleChange = (event) => {
  emit('customChange', event.target.value.toUpperCase())
}*/
onMounted(() => {
  //emit('counterIncremented', 'Testing') // not a string, warning!
})
///emit('counter-incremented', 'JUst a test');
</script>

<template>
  <div>
  <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ text }}</h1>
      </div>
  </header>
  </div>
</template>

