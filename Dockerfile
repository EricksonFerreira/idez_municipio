# Estágio de build
FROM composer:2.6 AS builder

WORKDIR /app
COPY . .
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --no-dev

# Estágio de produção
FROM php:8.2-cli

# Instala dependências do sistema mínimas
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip

# Instala o servidor web embutido do PHP
RUN apt-get update && apt-get install -y wget

# Cria diretório para o aplicativo
WORKDIR /var/www

# Copia os arquivos do estágio de build
COPY --from=builder /app /var/www

# Configura permissões
RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

# Configura o PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Expõe a porta 8000
EXPOSE 8000

# Cria um arquivo SQLite vazio se não existir
RUN touch /var/www/database/database.sqlite

# Comando para iniciar o servidor embutido do PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
