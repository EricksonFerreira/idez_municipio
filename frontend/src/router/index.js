import { createRouter, createWebHashHistory } from 'vue-router'
import MunicipiosList from '@/views/MunicipiosList.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: MunicipiosList
  },
  {
    path: '/estado/:uf',
    name: 'estado',
    component: MunicipiosList,
    props: true
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior() {
    // Sempre rola para o topo ao mudar de rota
    return { top: 0 }
  }
})

export default router
