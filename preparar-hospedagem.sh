#!/bin/bash

# Cria a estrutura de pastas
mkdir -p public_html/api
mkdir -p public_html/frontend

# Copia os arquivos da API (pasta public do Laravel)
cp -r public/* public_html/api/

# Instala as dependências do frontend e gera o build
cd frontend
npm install
npm run build

# Copia o build do frontend para a pasta correta
cp -r dist/* ../public_html/frontend/
cd ..

# Copia o .htaccess raiz
cp .htaccess public_html/

# Cria um arquivo de configuração básico para a API
cat > public_html/api/.env << 'EOL'
APP_NAME="Municipios API"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://seu-dominio.com
APP_KEY=base64:$(head -c 32 /dev/urandom | base64)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

MUNICIPIOS_PROVIDER=ibge
EOL

echo "Preparação concluída!"
echo "1. Compacte a pasta public_html: tar -czf municipios-hospedagem.tar.gz public_html"
echo "2. Faça upload do arquivo para sua hospedagem"
echo "3. Extraia o arquivo na raiz do seu domínio"
echo "4. Configure o banco de dados e atualize o arquivo public_html/api/.env"
