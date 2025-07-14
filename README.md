<p align="center">
  <h1 align="center">API de Municípios Brasileiros</h1>
  <p align="center">API RESTful para consulta de municípios brasileiros por estado (UF) com suporte a Docker</p>
</p>

<p align="center">
  <a href="https://github.com/EricksonFerreira/idez_municipio/actions">
    <img src="https://github.com/EricksonFerreira/idez_municipio/workflows/laravel.yml/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
  <a href="https://www.php.net/">
    <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php&logoColor=white" alt="PHP Version">
  </a>
  <a href="https://laravel.com/docs/10.x">
    <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel Version">
  </a>
  <a href="https://www.docker.com/">
    <img src="https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white" alt="Docker">
  </a>
</p>

## 🚀 Começando

### Pré-requisitos

- Docker e Docker Compose instalados
- Git (opcional, apenas para clonar o repositório)

### Instalação com Docker

1. Clone o repositório:
   ```bash
   git clone https://github.com/EricksonFerreira/idez_municipio.git
   cd idez_municipio
   ```

2. Crie o arquivo `.env` baseado no `.env.example`:
   ```bash
   cp .env.example .env
   ```

3. Inicie os contêineres:
   ```bash
   docker-compose up -d
   ```

4. Instale as dependências do Composer:
   ```bash
   docker-compose exec app composer install
   ```

5. Gere a chave da aplicação:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. Acesse a aplicação em:
   - API: http://localhost:8000

### Comandos úteis

- Parar os contêineres:
  ```bash
  docker-compose down
  ```

- Ver logs da aplicação:
  ```bash
  docker-compose logs -f app
  ```

- Acessar o terminal do container da aplicação:
  ```bash
  docker-compose exec app bash
  ```

## 📋 Sobre o Projeto

Esta é uma API RESTful desenvolvida em Laravel 12 que fornece informações sobre municípios brasileiros por estado (UF). A API consome dados de fontes externas (IBGE e BrasilAPI) e os disponibiliza em um formato padronizado, com suporte a paginação e cache para melhor desempenho.

### 🚀 Funcionalidades

- Consulta de municípios por UF
- Paginação de resultados
- Cache de respostas para melhor desempenho
- Suporte a múltiplos provedores de dados (IBGE, BrasilAPI)
- Documentação OpenAPI (Swagger) completa
- Testes automatizados

### 🔧 Provedores Suportados

- **IBGE** - Dados oficiais do Instituto Brasileiro de Geografia e Estatística
- **BrasilAPI** - Dados fornecidos pela BrasilAPI

> Por padrão, o sistema utiliza o provedor configurado na variável de ambiente `MUNICIPIOS_PROVIDER`

## 🚀 Começando

### 📋 Pré-requisitos

- PHP 8.1 ou superior
- Composer
- Extensões PHP necessárias: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML

### 🔧 Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/EricksonFerreira/idez_municipio.git
   cd idez_municipio
   ```

2. Instale as dependências:
   ```bash
   composer install
   ```

3. Configure o ambiente:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure o provedor de municípios no arquivo `.env`:
   ```env
   MUNICIPIOS_PROVIDER=IBGE  # ou BRASILAPI
   ```

5. (Opcional) Para desenvolvimento, você pode desativar a verificação SSL:
   ```env
   MUNICIPIOS_VERIFY_SSL=false
   ```

### 🚀 Executando a aplicação

```bash
# Inicie o servidor de desenvolvimento
php artisan serve

# Execute os testes
php artisan test
```

## 📚 Documentação da API

A documentação interativa da API está disponível em `/docs` após a instalação. A documentação é gerada automaticamente a partir das anotações do código-fonte. OpenAPI (Swagger). Você pode visualizá-la de duas formas:

 **Visualizar online**: Importe o arquivo `docs/openapi.yaml` em ferramentas como:
   - [Swagger Editor](https://editor.swagger.io/)
   - [Stoplight Studio](https://stoplight.io/studio/)
   - [Redocly](https://redocly.github.io/redoc/)
 

### 📝 Endpoints

#### Listar Municípios por UF

```
GET /api/municipios/{uf}
```

**Parâmetros de URL:**
- `uf` (obrigatório): Sigla da Unidade Federativa (2 caracteres)

**Parâmetros de consulta:**
- `page` (opcional, padrão: 1): Número da página
- `per_page` (opcional, padrão: 10, máximo: 100): Itens por página

**Exemplo de requisição:**
```bash
curl -X GET "http://localhost:8000/api/municipios/PE?page=1&per_page=5" \
     -H "Accept: application/json"
```

**Exemplo de resposta (200 OK):**
```json
{
  "current_page": 1,
  "data": [
    {
      "name": "Recife",
      "ibge_code": "2611606"
    },
    {
      "name": "Olinda",
      "ibge_code": "2609600"
    }
  ],
  "first_page_url": "http://localhost:8000/api/municipios/PE?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://localhost:8000/api/municipios/PE?page=1",
  "links": [
    {
      "url": null,
      "label": "&laquo; Anterior",
      "active": false
    },
    {
      "url": "http://localhost:8000/api/municipios/PE?page=1",
      "label": "1",
      "active": true
    },
    {
      "url": null,
      "label": "Próximo &raquo;",
      "active": false
    }
  ],
  "next_page_url": null,
  "path": "http://localhost:8000/api/municipios/PE",
  "per_page": 10,
  "prev_page_url": null,
  "to": 2,
  "total": 2
}
```

**Códigos de status HTTP:**
- 200: Sucesso
- 400: Formato de UF inválido
- 404: Nenhum município encontrado para a UF especificada
- 500: Erro interno do servidor

## 🧪 Testes

O projeto utiliza o framework de testes Pest PHP para testes unitários e de integração.

```bash
# Executar todos os testes
php artisan test

# Executar apenas testes unitários
php artisan test --testsuite=Unit

# Executar apenas testes de integração
php artisan test --testsuite=Feature

# Gerar relatório de cobertura de código (requer Xdebug)
XDEBUG_MODE=coverage php artisan test --coverage-html=coverage
```

## 🤝 Contribuindo

Contribuições são bem-vindas! Siga estes passos para contribuir:

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Adicione suas alterações (`git add .`)
4. Faça o Commit das suas alterações (`git commit -m 'Add some AmazingFeature'`)
4. Faça o Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 📚 Aprendendo Laravel

O Laravel possui uma [documentação](https://laravel.com/docs) extensiva e completa, além de uma biblioteca de tutoriais em vídeo, cobrindo todos os aspectos do framework.

Se você prefere aprender assistindo, o [Laracasts](https://laracasts.com) oferece milhares de tutoriais em vídeo sobre Laravel, PHP moderno, testes e muito mais.

## 🛡️ Segurança

Se você descobrir uma vulnerabilidade de segurança, por favor envie um e-mail para o mantenedor do projeto. Todas as vulnerabilidades de segurança serão prontamente tratadas.

## 📄 Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.
