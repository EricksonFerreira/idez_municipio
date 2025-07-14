import axios from 'axios'

const API_URL = 'https://buscamunicipio.ericksondevs.tech/api' // URL direta para a API

const municipiosService = {
  async getEstados() {
      const estados = {
        AC: "Acre", AL: "Alagoas", AP: "Amapá", AM: "Amazonas", BA: "Bahia", CE: "Ceará",
        DF: "Distrito Federal", ES: "Espírito Santo", GO: "Goiás", MA: "Maranhão", 
        MT: "Mato Grosso", MS: "Mato Grosso do Sul", MG: "Minas Gerais", PA: "Pará", 
        PB: "Paraíba", PR: "Paraná", PE: "Pernambuco", PI: "Piauí", RJ: "Rio de Janeiro", 
        RN: "Rio Grande do Norte", RS: "Rio Grande do Sul", RO: "Rondônia", RR: "Roraima", 
        SC: "Santa Catarina", SP: "São Paulo", SE: "Sergipe", TO: "Tocantins"
      };
      return estados;
  },

  async getMunicipiosPorEstado(uf, page = 1) {
    try {
      const response = await axios.get(`${API_URL}/municipios/${uf}`, {
        params: { page }
      })
      return response.data
    } catch (error) {
      console.error(`Erro ao buscar municípios de ${uf}:`, error)
      throw error
    }
  }
}

export default municipiosService
