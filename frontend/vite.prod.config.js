import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'
import { resolve } from 'path'
import { readFileSync, writeFileSync } from 'fs'

// Lê o conteúdo do arquivo index.html original
const htmlTemplate = readFileSync(resolve(__dirname, 'index.html'), 'utf-8')

// Cria uma versão personalizada do index.html para produção
const createHtmlPlugin = () => ({
  name: 'html-transform',
  transformIndexHtml(html) {
    // Adiciona os scripts de depuração ao HTML
    return htmlTemplate
      .replace('</head>', 
        `  <script>
          console.log('Iniciando carregamento da aplicação...');
          window.addEventListener('error', function(event) {
            console.error('Erro capturado:', event.error);
          });
          window.addEventListener('unhandledrejection', function(event) {
            console.error('Erro não tratado na promise:', event.reason);
          });
        </script>
      </head>`)
      .replace('</body>', 
        `  <script>
          // Função para exibir mensagens de depuração na página
          function logDebug(message) {
            console.log(message);
            const debugLog = document.getElementById('debug-log');
            const debugInfo = document.getElementById('debug-info');
            if (debugLog && debugInfo) {
              debugLog.textContent += message + '\n';
              debugInfo.scrollTop = debugInfo.scrollHeight; // Auto-scroll para a última mensagem
              debugInfo.classList.remove('hidden');
            }
          }

          // Verifica se o Vue foi carregado corretamente
          window.addEventListener('DOMContentLoaded', () => {
            logDebug('DOM totalmente carregado');
            
            // Verifica se o elemento #app foi substituído pelo Vue
            const checkVueMounted = setInterval(() => {
              const appElement = document.getElementById('app');
              if (appElement && appElement.children.length > 1) {
                logDebug('Vue parece ter sido montado com sucesso');
                clearInterval(checkVueMounted);
              }
            }, 500);

            // Timeout para garantir que não fique verificando para sempre
            setTimeout(() => {
              clearInterval(checkVueMounted);
            }, 10000);
          });
        </script>
      </body>`)
      .replace('<div id="app">', 
        `<div id="app">
          <div class="flex items-center justify-center min-h-screen">
            <div class="text-center">
              <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
              <p class="mt-4 text-gray-600">Carregando aplicação...</p>
              <div id="debug-info" class="mt-4 p-4 bg-gray-100 rounded-md text-left text-sm text-gray-700 max-w-md mx-auto hidden">
                <h3 class="font-bold mb-2">Informações de Depuração:</h3>
                <pre id="debug-log" class="whitespace-pre-wrap"></pre>
              </div>
            </div>
          </div>`)
  }
})

export default defineConfig({
  base: './', // Usando caminho relativo para funcionar em subdiretórios
  root: './',
  publicDir: 'public',
  plugins: [
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => tag.includes('-')
        },
        transformAssetUrls: {
          includeAbsolute: false,
        },
      },
    }),
    createHtmlPlugin()
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      '~': fileURLToPath(new URL('./node_modules', import.meta.url))
    },
    extensions: ['.js', '.json', '.vue', '.scss', '.css']
  },
  build: {
    outDir: 'dist',
    assetsDir: 'assets',
    emptyOutDir: true,
    manifest: true,
    sourcemap: true,
    minify: 'terser',
    terserOptions: {
      compress: {
        drop_console: false, // Mantém os logs no console para depuração
        drop_debugger: true,
      },
    },
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'index.html')
      },
      output: {
        manualChunks: {
          vue: ['vue', 'vue-router', 'pinia'],
          vendor: ['axios', 'lodash']
        },
        entryFileNames: 'assets/js/[name].[hash].js',
        chunkFileNames: 'assets/js/[name].[hash].js',
        assetFileNames: (assetInfo) => {
          const info = assetInfo.name.split('.');
          const ext = info[info.length - 1];
          
          if (['png', 'jpe?g', 'svg', 'gif', 'webp', 'avif'].includes(ext)) {
            return 'assets/images/[name].[hash][extname]';
          }
          
          if (['css', 'scss'].includes(ext)) {
            return 'assets/css/[name].[hash][extname]';
          }
          
          if (['woff', 'woff2', 'eot', 'ttf', 'otf'].includes(ext)) {
            return 'assets/fonts/[name].[hash][extname]';
          }
          
          return 'assets/[name].[hash][extname]';
        }
      }
    }
  },
  server: {
    port: 3000,
    open: true,
    cors: true
  }
})
