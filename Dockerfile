# =============================================================================
# Stage 1: Node.js — Build frontend assets (Vite + Tailwind)
# =============================================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY public/ ./public/

RUN npm run build

# =============================================================================
# Stage 2: PHP — Install Composer dependencies
# =============================================================================
FROM composer:2.7 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist

COPY . .
RUN composer dump-autoload --optimize --no-dev

# =============================================================================
# Stage 3: Final Production Image
# =============================================================================
FROM php:8.2-fpm-alpine AS production

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && rm -rf /var/cache/apk/*

# Set working directory
WORKDIR /var/www/html

# Copy vendor from composer stage
COPY --from=composer-builder /app/vendor ./vendor

# Copy built frontend assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Copy application source
COPY . .

# Copy config files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/laravel.ini
COPY docker/start.sh /usr/local/bin/start.sh

# Set permissions
RUN chmod +x /usr/local/bin/start.sh \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port (Render uses 10000 by default, but we use 80 via nginx)
EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
