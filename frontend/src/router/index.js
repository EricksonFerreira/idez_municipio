import { createRouter, createWebHistory } from 'vue-router'
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
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
