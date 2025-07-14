# Configuração para Hospedagem Compartilhada

Este guia explica como configurar o projeto em uma hospedagem compartilhada.

## Estrutura de Arquivos

Certifique-se de que a estrutura de arquivos na hospedagem esteja assim:
```
public_html/
├── .htaccess
├── api/           # Pasta da API (pasta public do Laravel)
├── frontend/      # Pasta do frontend (build de produção)
└── ...
```

## Configuração do .htaccess

O arquivo `.htaccess` na raiz do projeto já está configurado para:
1. Redirecionar todas as requisições para a pasta `public`
2. Rotear corretamente as chamadas da API

## Configuração do Frontend

1. Gere o build de produção do frontend:
   ```bash
   cd frontend
   npm install
   npm run build
   ```

2. Faça upload da pasta `frontend/dist` para `public_html/frontend`

3. Atualize a URL da API no arquivo `frontend/dist/assets/*.js` para apontar para o domínio correto.

## Configuração da API

1. Faça upload da pasta `public` do Laravel para `public_html/api`

2. Certifique-se de que o arquivo `public_html/api/.htaccess` contenha:
   ```apache
   <IfModule mod_rewrite.c>
       <IfModule mod_negotiation.c>
           Options -MultiViews -Indexes
       </IfModule>

       RewriteEngine On

       # Handle Authorization Header
       RewriteCond %{HTTP:Authorization} .
       RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

       # Redirect Trailing Slashes If Not A Folder...
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_URI} (.+)/$
       RewriteRule ^ %1 [L,R=301]

       # Send Requests To Front Controller...
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteRule ^ index.php [L]
   </IfModule>
   ```

## Configuração do Banco de Dados

1. Crie um banco de dados MySQL na sua hospedagem
2. Atualize o arquivo `public_html/api/.env` com as credenciais do banco de dados
3. Execute as migrações:
   ```bash
   cd public_html/api
   php artisan migrate --force
   ```

## Configuração do Domínio

1. Configure o domínio para apontar para a pasta `public_html`
2. Certifique-se de que o SSL esteja configurado corretamente

## Solução de Problemas

- **Erro 500**: Verifique as permissões das pastas (755 para pastas, 644 para arquivos)
- **Erro de rota não encontrada**: Verifique se o `mod_rewrite` está habilitado
- **Erro de banco de dados**: Verifique as credenciais no arquivo `.env`

## Notas Importantes

- Certifique-se de que a versão do PHP seja compatível (PHP 8.1+)
- O servidor deve ter suporte a Node.js para build do frontend
- Recomenda-se configurar um cron job para o agendador do Laravel
