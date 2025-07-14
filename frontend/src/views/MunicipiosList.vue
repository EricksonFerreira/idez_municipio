<template>
  <div class="p-8 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Municípios por Estado</h1>
    
    <!-- Seletor de Estado -->
    <EstadoSelector 
      v-model="estadoSelecionado"
      :estados="estados"
      :loading="loading"
      @update:modelValue="resetarBusca"
    />

    <!-- Loading inicial -->
    <LoadingSpinner v-if="loading && !municipios.length" size="lg" />

    <!-- Lista de Municípios -->
    <div v-else class="mt-6">
      <div v-if="municipios.length === 0" class="text-center text-gray-500 py-12">
        <p>Nenhum município encontrado para o estado selecionado.</p>
      </div>
      <div v-else>
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold">Municípios de {{ estadoAtual?.nome || '' }}</h2>
          <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            {{ totalMunicipios }} municípios
          </span>
        </div>
        
        <div class="relative">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div 
              v-for="municipio in municipios" 
              :key="municipio.ibge_code"
              class="p-4 border rounded-lg hover:shadow-md transition-shadow duration-200"
            >
              <h3 class="font-medium text-blue-600 truncate">{{ municipio.name }}</h3>
              <p class="text-sm text-gray-500 mt-1">Código: {{ municipio.ibge_code }}</p>
              <div class="mt-2 pt-2 border-t border-gray-100">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  {{ estadoSelecionado }}
                </span>
              </div>
            </div>
          </div>
          
          <!-- Elemento de observação para o scroll infinito -->
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
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import municipiosService from '@/services/municipiosService'
import EstadoSelector from '@/components/EstadoSelector.vue'
import LoadingSpinner from '@/components/LoadingSpinner.vue'

// Dados reativos
const estados = ref([])
const municipios = ref([])
const loading = ref(false)
const loadingMore = ref(false)
const estadoSelecionado = ref('')
const currentPage = ref(1)
const lastPage = ref(1)
const totalMunicipios = ref(0)
const hasMore = ref(true)
const loadMoreTrigger = ref(null)
let observer = null
// Estado atual selecionado
const estadoAtual = computed(() => 
  estados.value.find(e => e.sigla === estadoSelecionado.value) || null
)

// Carrega os estados ao montar o componente
onMounted(async () => {
  try {
    loading.value = true
    const data = await municipiosService.getEstados()
    // Ordena os estados por nome
    const estadosOrdenados = Object.entries(data).map(([sigla, nome]) => ({ sigla, nome }));
    estados.value = estadosOrdenados.sort((a, b) => a.nome.localeCompare(b.nome))
    
    // Configura o Intersection Observer
    setupIntersectionObserver()
  } catch (error) {
    console.error('Erro ao carregar estados:', error)
    alert('Erro ao carregar a lista de estados. Tente novamente.')
  } finally {
    loading.value = false
  }
})

// Configura o Intersection Observer para carregar mais itens
function setupIntersectionObserver() {
  // Cria um novo Intersection Observer
  observer = new IntersectionObserver((entries) => {
    const firstEntry = entries[0]
    if (firstEntry.isIntersecting && hasMore.value && !loadingMore.value && !loading.value) {
      carregarMaisMunicipios()
    }
  }, {
    threshold: 0.1, // Dispara quando 10% do elemento estiver visível
    rootMargin: '200px' // Carrega 200px antes de chegar no final
  })

  // Observa o elemento de trigger
  if (loadMoreTrigger.value) {
    observer.observe(loadMoreTrigger.value)
  }
}

// Limpa o observer quando o componente for desmontado
onBeforeUnmount(() => {
  if (observer) {
    observer.disconnect()
  }
})

// Reseta a busca quando o estado é alterado
function resetarBusca() {
  municipios.value = []
  currentPage.value = 1
  hasMore.value = true
  carregarMaisMunicipios()
}

// Carrega mais municípios para o estado selecionado
async function carregarMaisMunicipios() {
  if (!estadoSelecionado.value || !hasMore.value || loading.value || loadingMore.value) {
    return
  }

  try {
    if (currentPage.value === 1) {
      loading.value = true
    } else {
      loadingMore.value = true
    }

    const response = await municipiosService.getMunicipiosPorEstado(
      estadoSelecionado.value, 
      currentPage.value
    )

    // Atualiza os dados de paginação
    currentPage.value = response.current_page + 1
    lastPage.value = response.last_page
    totalMunicipios.value = response.total
    hasMore.value = response.current_page < response.last_page

    // Adiciona os novos municípios à lista
    municipios.value = [...municipios.value, ...(response.data || [])]
  } catch (error) {
    console.error('Erro ao carregar municípios:', error)
    alert('Erro ao carregar mais municípios. Tente novamente.')
  } finally {
    loading.value = false
    loadingMore.value = false
  }
}


</script>
