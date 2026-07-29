# Stage 1: Build Frontend Assets with Node.js
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci --prefer-offline --no-audit
COPY . .
RUN npm run build

# Stage 2: Install Composer Dependencies
FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs --no-scripts

# Stage 3: Production Image (PHP 8.2 FPM + Nginx + Supervisor)
FROM php:8.2-fpm-alpine

# Install system dependencies, Nginx, Supervisor, and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    gettext \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        opcache \
        intl \
        bcmath \
        exif

WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Copy compiled vendor and public/build from previous stages
COPY --from=composer-builder /app/vendor /var/www/html/vendor
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Copy Nginx & Supervisord configurations
COPY .nginx/nginx.conf /etc/nginx/nginx.conf.template
COPY .docker/supervisord.conf /etc/supervisord.conf

# Configure PHP-FPM to listen on Unix Socket /var/run/php-fpm.sock
RUN sed -i 's|^listen = .*|listen = /var/run/php-fpm.sock|' /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "listen.mode = 0666" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && sed -i 's|^listen = .*|listen = /var/run/php-fpm.sock|' /usr/local/etc/php-fpm.d/www.conf 2>/dev/null || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod +x /var/www/html/docker-entrypoint.sh

EXPOSE 80 8080 9000

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
