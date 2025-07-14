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
    <MunicipiosList 
      v-else
      :municipios="municipios"
      :estado-sigla="estadoSelecionado"
      :estado-nome="estadoAtual?.nome || ''"
      :loading="loading"
      :loading-more="loadingMore"
      :has-more="hasMore"
      :total-municipios="totalMunicipios"
      @load-more="carregarMaisMunicipios"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import municipiosService from '@/services/municipiosService'
import EstadoSelector from '@/components/EstadoSelector.vue'
import MunicipiosList from '@/components/MunicipiosList.vue'
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
  } catch (error) {
    console.error('Erro ao carregar estados:', error)
    alert('Erro ao carregar a lista de estados. Tente novamente.')
  } finally {
    loading.value = false
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
