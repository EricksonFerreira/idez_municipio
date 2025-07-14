# Frontend para API de Municípios

Aplicação Vue.js 3 que consome a API de Municípios do Brasil.

## Pré-requisitos

- Node.js 16+ (recomendado a versão LTS mais recente)
- npm ou yarn
- API de Municípios rodando em `http://localhost:8000`

## Configuração

1. Instale as dependências:

```bash
npm install
# ou
yarn
```

2. Configure o proxy no arquivo `vite.config.js` se a API estiver em um endereço diferente de `http://localhost:8000`.

## Executando o projeto

Para iniciar o servidor de desenvolvimento:

```bash
npm run dev
# ou
yarn dev
```

O aplicativo estará disponível em [http://localhost:3000](http://localhost:3000).

## Construção para produção

Para criar uma versão otimizada para produção:

```bash
npm run build
# ou
yarn build
```

Os arquivos de produção serão gerados na pasta `dist/`.

## Funcionalidades

- Lista de municípios por estado
- Busca por nome de município
- Paginação de resultados
- Interface responsiva

## Estrutura do Projeto

```
frontend/
├── src/
│   ├── components/     # Componentes Vue reutilizáveis
│   ├── views/          # Páginas/rotas
│   ├── router/         # Configuração de rotas
│   ├── services/       # Serviços da API
│   ├── App.vue         # Componente raiz
│   └── main.js         # Ponto de entrada da aplicação
├── public/             # Arquivos estáticos
├── index.html          # Template HTML principal
└── vite.config.js      # Configuração do Vite
```

## Variáveis de Ambiente

O projeto utiliza as seguintes variáveis de ambiente:

- `VITE_API_URL`: URL base da API (padrão: `http://localhost:8000`)

## Dependências Principais

- Vue 3
- Vue Router
- Pinia (gerenciamento de estado)
- Axios (requisições HTTP)
- Tailwind CSS (estilização)
- Vite (build tool)
