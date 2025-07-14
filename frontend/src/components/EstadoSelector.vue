<template>
  <div class="sticky top-0 bg-white z-10 pt-2 pb-4">
    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
      Selecione um estado:
    </label>
    <select
      id="estado"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
      class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
      :disabled="loading"
    >
      <option value="">Selecione um estado</option>
      <option v-for="estado in estados" :key="estado.sigla" :value="estado.sigla">
        {{ estado.nome }} ({{ estado.sigla }})
      </option>
    </select>
  </div>
</template>

<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true
  },
  estados: {
    type: Array,
    required: true
  },
  loading: {
    type: Boolean,
    default: false
  }
});

defineEmits(['update:modelValue']);
</script>
