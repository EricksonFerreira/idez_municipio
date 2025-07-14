# Arquitetura da Aplicação

Este documento descreve a arquitetura e as decisões de projeto tomadas no desenvolvimento da API de Municípios Brasileiros.

## Visão Geral

A aplicação segue os princípios da arquitetura limpa (Clean Architecture) e do design pattern Repository, com uma clara separação de responsabilidades entre as camadas.

## Estrutura de Diretórios

```
app/
├── Console/
├── Exceptions/          # Tratamento de exceções personalizadas
├── Http/
│   ├── Controllers/     # Controladores da API
│   └── Middleware/      # Middlewares personalizados
├── Models/              # Modelos Eloquent (se necessário)
└── Services/
    ├── Contracts/       # Interfaces dos serviços
    ├── DTOs/            # Objetos de Transferência de Dados
    └── Providers/       # Implementações dos provedores de dados

tests/
├── Feature/             # Testes de integração/aceitação
└── Unit/                # Testes unitários
```

## Padrões de Projeto

### Repository Pattern

O padrão Repository é utilizado para abstrair o acesso aos dados, permitindo que a camada de negócios não precise saber de onde os dados vêm (API externa, banco de dados, etc.).

### Strategy Pattern

O padrão Strategy é utilizado para permitir a troca dinâmica entre diferentes provedores de dados (IBGE, BrasilAPI) sem modificar o código que os utiliza.

### Factory Pattern

Utilizado para criar instâncias dos provedores de dados de forma dinâmica com base na configuração.

## Fluxo de Dados

1. **Requisição HTTP**
   - O cliente faz uma requisição para `/api/municipios/{uf}`
   - O roteamento do Laravel direciona para o `MunicipioController@index`

2. **Camada de Controle**
   - O controlador valida os parâmetros de entrada
   - Chama o serviço `MunicipioService`
   - Retorna a resposta formatada

3. **Camada de Serviço**
   - Verifica se os dados estão em cache
   - Se não estiverem, chama o provedor configurado
   - Formata os dados para o formato padrão
   - Armazena em cache para consultas futuras

4. **Provedores de Dados**
   - Implementam a interface `MunicipioProviderInterface`
   - São responsáveis por se comunicar com as APIs externas
   - Tratam erros específicos de cada provedor
   - Mapeiam os dados para o formato padrão

## Cache

- **Chave**: `municipios:{uf}`
- **Tempo de vida**: 1 hora
- **Estratégia**: Cache Aside

## Tratamento de Erros

- **400 Bad Request**: UF inválida (formato incorreto)
- **404 Not Found**: Nenhum município encontrado para a UF
- **500 Internal Server Error**: Erro ao acessar o provedor de dados
- **503 Service Unavailable**: Provedor de dados indisponível

## Logs

- Todas as requisições são registradas no arquivo de log do Laravel
- Erros são registrados com stack trace completo
- Nível de log configurável via `.env`

## Segurança

- Validação de entrada em todas as requisições
- Rate limiting configurado para evitar abuso
- Headers de segurança habilitados (CSP, HSTS, etc.)
- Desativação de informações sensíveis em modo de depuração

## Escalabilidade

- Stateless por design
- Cache para reduzir chamadas a APIs externas
- Fácil adição de novos provedores de dados
- Configuração flexível via variáveis de ambiente

## Monitoramento

- Health check endpoint em `/health`
- Métricas básicas de desempenho
- Logs estruturados para análise

## Próximos Passos

- [ ] Adicionar autenticação JWT
- [ ] Implementar documentação interativa com Swagger UI
- [ ] Adicionar suporte a GraphQL
- [ ] Implementar filas para processamento assíncrono
- [ ] Adicionar suporte a WebSockets para atualizações em tempo real
