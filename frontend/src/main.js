import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import './assets/main.css'

// Cria e monta a aplicação
async function initApp() {
  const app = createApp(App)
  
  // Plugins
  app.use(createPinia())
  app.use(router)
  
  // Monta o app
  await router.isReady()
  app.mount('#app')
  
  console.log('Aplicação Vue inicializada')
}

// Inicializa a aplicação
initApp().catch(error => {
  console.error('Falha ao inicializar a aplicação:', error)
})
