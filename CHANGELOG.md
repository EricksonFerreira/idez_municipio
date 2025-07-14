# Registro de Alterações

Todas as alterações notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-07-13

### Adicionado
- Endpoint `GET /api/municipios/{uf}` para listar municípios por UF
- Suporte a múltiplos provedores de dados (IBGE e BrasilAPI)
- Sistema de cache para melhorar desempenho
- Documentação OpenAPI (Swagger)
- Testes unitários e de integração
- Configuração de ambiente via variáveis
- Tratamento de erros personalizado
- Paginação de resultados
- Documentação detalhada em português
- Arquivo de arquitetura e decisões de projeto

### Alterado
- Melhorias na estrutura do projeto
- Refatoração do código para melhor manutenibilidade
- Atualização das dependências

### Corrigido
- Problemas de validação de UF
- Tratamento de erros em chamadas de API externas
- Problemas de cache

## [0.1.0] - 2025-07-01

### Adicionado
- Estrutura inicial do projeto Laravel
- Configuração básica do ambiente
- Primeira versão do serviço de municípios
- Testes iniciais
