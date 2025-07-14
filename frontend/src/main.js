import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import './assets/main.css'

// Função para exibir mensagem de erro na interface
function showError(message) {
  const appElement = document.getElementById('app');
  if (appElement) {
    appElement.innerHTML = `
      <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
          <div class="text-red-500 text-5xl mb-4">
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <h1 class="text-2xl font-bold text-gray-800 mb-4">Ocorreu um erro</h1>
          <p class="text-gray-600 mb-6">${message}</p>
          <button 
            onclick="window.location.reload()" 
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            Tentar novamente
          </button>
        </div>
      </div>
    `;
  }
}

// Função para verificar se o navegador é compatível
function checkBrowserCompatibility() {
  const requiredFeatures = [
    'Promise' in window,
    'fetch' in window,
    'Proxy' in window,
    'Map' in window,
    'Set' in window,
    'Symbol' in window,
    'Object' in window && 'assign' in Object,
    'Array' in window && 'from' in Array,
    'isFinite' in Number,
    'isNaN' in Number
  ];
  
  const isCompatible = requiredFeatures.every(feature => feature === true);
  
  if (!isCompatible) {
    showError('Seu navegador não é compatível com esta aplicação. Por favor, atualize para a versão mais recente do seu navegador.');
    return false;
  }
  
  return true;
}

// Cria e monta a aplicação
async function initApp() {
  try {
    // Verifica a compatibilidade do navegador
    if (!checkBrowserCompatibility()) {
      return;
    }
    
    // Cria a instância do Vue
    const app = createApp(App);
    
    // Adiciona tratamento global de erros
    app.config.errorHandler = (err, vm, info) => {
      console.error('Erro no componente:', err);
      console.error('Informações adicionais:', info);
      showError('Ocorreu um erro inesperado na aplicação. Por favor, recarregue a página.');
    };
    
    // Adiciona handler para erros não capturados
    window.onerror = function(message, source, lineno, colno, error) {
      console.error('Erro não capturado:', { message, source, lineno, colno, error });
      showError('Ocorreu um erro inesperado. Por favor, tente novamente.');
      return true; // Impede que o erro seja registrado no console
    };
    
    // Adiciona handler para rejeições de promessas não tratadas
    window.onunhandledrejection = function(event) {
      console.error('Rejeição de promessa não tratada:', event.reason);
      showError('Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente.');
      event.preventDefault(); // Impede o log padrão do navegador
    };
    
    // Registra os plugins
    app.use(createPinia());
    app.use(router);
    
    // Aguarda o roteador estar pronto antes de montar a aplicação
    await router.isReady();
    
    // Monta a aplicação
    app.mount('#app');
    
    console.log('Aplicação Vue inicializada com sucesso!');
    
  } catch (error) {
    console.error('Falha crítica ao inicializar a aplicação:', error);
    showError('Não foi possível carregar a aplicação. Por favor, verifique sua conexão e tente novamente.');
    
    // Tenta registrar o erro em um serviço de monitoramento, se disponível
    if (window.trackError) {
      window.trackError({
        type: 'APP_INIT_ERROR',
        error: error.toString(),
        stack: error.stack,
        timestamp: new Date().toISOString()
      });
    }
  }
}

// Inicializa a aplicação quando o DOM estiver pronto
if (document.readyState === 'loading') {
  // O DOM ainda não foi totalmente carregado
  document.addEventListener('DOMContentLoaded', initApp);
} else {
  // O DOM já foi carregado
  initApp();
}
