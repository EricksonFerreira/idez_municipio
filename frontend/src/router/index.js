import { createRouter, createWebHistory } from 'vue-router'
import MunicipiosList from '@/views/MunicipiosList.vue'

const router = createRouter({
  history: createWebHistory('/'),
  routes: [
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
})

export default router
