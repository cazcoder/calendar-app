<script setup>
let props = defineProps(['modelValue', 'label', 'type', 'id', 'hint'])
defineEmits(['update:modelValue'])
</script>

<template>
  <label :for="id" v-if="label" class="mb-2 ml-1 font-bold text-xs text-slate-700">{{ label }}</label>
  <div class="mb-4">
    <input :id="id" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :type="type" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
    <div class="text-sm" v-if="hint">{{ hint }}</div>
  </div>
</template>

