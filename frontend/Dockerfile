FROM node:18-alpine

WORKDIR /app

# Copiar arquivos de definição de dependências
COPY package*.json ./

# Instalar dependências
RUN npm install

# Copiar o restante dos arquivos
COPY . .

# Expor a porta 3000
EXPOSE 3000

# Iniciar o servidor de desenvolvimento
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]
