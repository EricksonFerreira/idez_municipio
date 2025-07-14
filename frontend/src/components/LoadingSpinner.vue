<template>
  <div :class="['flex justify-center', containerClass]">
    <div class="animate-spin rounded-full border-t-2 border-b-2 border-blue-500" :class="spinnerClass"></div>
  </div>
</template>

<script setup>
const props = defineProps({
  containerClass: {
    type: String,
    default: 'my-8'
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  }
});

const spinnerSizes = {
  sm: 'h-6 w-6',
  md: 'h-8 w-8',
  lg: 'h-12 w-12'
};

const spinnerClass = spinnerSizes[props.size];
</script>
