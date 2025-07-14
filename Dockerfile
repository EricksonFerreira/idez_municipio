# Estágio de build
FROM composer:2.6 AS builder

WORKDIR /app
COPY . .
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Estágio de produção
FROM php:8.1-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Node.js e NPM
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Configuração do PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Configuração do diretório de trabalho
WORKDIR /var/www

# Copia os arquivos da aplicação
COPY --from=builder /app /var/www
COPY --from=builder /usr/bin/composer /usr/bin/composer

# Configura permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Instala dependências do frontend (se necessário)
# RUN npm install && npm run production

# Gera a chave da aplicação
RUN php artisan key:generate

# Expõe a porta 9000 e inicia o php-fpm
EXPOSE 9000
CMD ["php-fpm"]
