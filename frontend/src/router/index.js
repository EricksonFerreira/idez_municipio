import { createRouter, createWebHistory } from 'vue-router'
import MunicipiosList from '@/views/MunicipiosList.vue'

const router = createRouter({
  history: createWebHistory(process.env.NODE_ENV === 'production' ? '/' : '/'),
  routes: [
    {
      path: '/',
      name: 'home',
      component: MunicipiosList,
      meta: { title: 'Municípios do Brasil' }
    },
    {
      path: '/estado/:uf',
      name: 'estado',
      component: MunicipiosList,
      props: true,
      meta: { title: 'Municípios - ' }
    },
    {
      path: '/:pathMatch(.*)*',
      redirect: '/'
    }
  ],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

// Adiciona um hook global para gerenciar o título da página
router.beforeEach((to, from, next) => {
  // Define o título da página com base na rota
  document.title = to.meta.title || 'Municípios do Brasil';
  next();
});

// Adiciona um hook global para tratamento de erros
router.onError((error) => {
  console.error('Erro de roteamento:', error);
  // Redireciona para a página inicial em caso de erro
  if (error.name === 'ChunkLoadError') {
    window.location.href = '/';
  }
});

export default router
