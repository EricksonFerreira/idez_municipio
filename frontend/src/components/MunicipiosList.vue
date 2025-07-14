<template>
  <div class="w-full">
    <div v-if="municipios.length === 0 && !loading" class="text-center text-gray-500 py-12">
      <p class="text-lg">Nenhum município encontrado para o estado selecionado.</p>
    </div>

    <div v-else>
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">
          Municípios de {{ estadoNome }}
        </h2>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
          {{ totalMunicipios }} municípios
        </span>
      </div>
      
      <div class="relative">
        <div 
          ref="municipiosContainer"
          class="flex flex-wrap -mx-2"
        >
          <template v-for="municipio in municipios" :key="municipio.ibge_code">
            <MunicipioItem 
              :municipio="municipio"
              :estado-sigla="estadoSigla"
            />
          </template>
        </div>
        
        <!-- Elemento de observação para o Intersection Observer -->
        <div 
          ref="loadMoreTrigger"
          class="h-1 w-full"
        ></div>
        
        <LoadingSpinner 
          v-if="loadingMore" 
          size="md" 
          class="my-4" 
        />
        
        <div 
          v-if="!hasMore && municipios.length > 0" 
          class="text-center text-gray-500 py-6 text-sm border-t border-gray-100 mt-4"
        >
          <p>Você viu todos os {{ totalMunicipios }} municípios</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { debounce } from 'lodash';
import MunicipioItem from './MunicipioItem.vue';
import LoadingSpinner from './LoadingSpinner.vue';

const props = defineProps({
  municipios: {
    type: Array,
    required: true
  },
  estadoSigla: {
    type: String,
    required: true
  },
  estadoNome: {
    type: String,
    required: true
  },
  loading: {
    type: Boolean,
    default: false
  },
  loadingMore: {
    type: Boolean,
    default: false
  },
  hasMore: {
    type: Boolean,
    default: true
  },
  totalMunicipios: {
    type: Number,
    default: 0
  }
});

const emit = defineEmits(['load-more']);
const loadMoreTrigger = ref(null);
const municipiosContainer = ref(null);
let observer = null;

const checkScroll = debounce(() => {
  if (!loadMoreTrigger.value || !municipiosContainer.value) return;
  
  const trigger = loadMoreTrigger.value.getBoundingClientRect();
  const isVisible = trigger.top < window.innerHeight + 200; // 200px antes de chegar no final
  
  if (isVisible && props.hasMore && !props.loadingMore) {
    emit('load-more');
  }
}, 100);

onMounted(() => {
  // Usa Intersection Observer para detectar quando o usuário está perto do final
  observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && props.hasMore && !props.loadingMore) {
      emit('load-more');
    }
  }, {
    root: null,
    rootMargin: '200px',
    threshold: 0.1
  });

  if (loadMoreTrigger.value) {
    observer.observe(loadMoreTrigger.value);
  }

  // Adiciona um listener de scroll para o caso do Intersection Observer não estar disponível
  window.addEventListener('scroll', checkScroll, { passive: true });
});

onBeforeUnmount(() => {
  if (observer) {
    observer.disconnect();
  }
  window.removeEventListener('scroll', checkScroll);
});
</script>
