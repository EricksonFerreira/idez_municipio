<template>
  <div class="p-2 w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
    <div class="p-4 h-full border rounded-lg hover:shadow-md transition-shadow duration-200">
      <div class="flex flex-col h-full">
        <div class="flex-grow">
          <h3 class="font-medium text-blue-600 truncate">
            {{ municipio.name }}
          </h3>
          <p class="text-sm text-gray-500 mt-1">
            Código: {{ municipio.ibge_code }}
          </p>
        </div>
        <div class="mt-2 pt-2 border-t border-gray-100">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            {{ estadoSigla }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  municipio: {
    type: Object,
    required: true
  },
  estadoSigla: {
    type: String,
    required: true
  }
});
</script>
