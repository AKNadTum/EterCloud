# Stage 1: PHP dependencies
FROM composer:2.7 as vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Frontend assets
FROM node:20-alpine as frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm install && npm run build

# Stage 3: Production image
FROM dunglas/frankenphp:1-php8.4-alpine

# Install system dependencies and PHP extensions
RUN install-php-extensions \
    pcntl \
    bcmath \
    gd \
    intl \
    pdo_mysql \
    zip \
    opcache \
    redis

# Configure PHP for production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/variables_order = "GPCS"/variables_order = "EGPCS"/' "$PHP_INI_DIR/php.ini"

WORKDIR /app

# Copy application code
COPY . .

# Copy vendor and public/build from previous stages
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Finish composer (dump-autoload and run scripts)
RUN composer dump-autoload --optimize --no-dev

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Create storage link
RUN php artisan storage:link

# Entrypoint script for migrations
COPY --chmod=755 docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh

# Environment variables for FrankenPHP
ENV FRANKENPHP_CONFIG="worker ./public/index.php"
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expose port
EXPOSE 80 443 443/udp

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
