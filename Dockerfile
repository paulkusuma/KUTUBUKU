# --- STAGE 1: Backend (PHP & Composer) ---
FROM php:8.2-fpm-alpine AS backend-builder
RUN apk add --no-cache git unzip libpng-dev libxml2-dev oniguruma-dev
RUN docker-php-ext-install pdo pdo_mysql mbstring gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .
RUN composer install --no-dev --optimize-autoloader

# --- STAGE 2: Frontend (Node.js) ---
FROM node:18-alpine AS frontend-builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# --- STAGE 3: Final Production Image ---
FROM php:8.2-fpm-alpine
WORKDIR /var/www

# Install runtime dependencies yang esensial saja
RUN apk add --no-cache libpng libxml2 oniguruma
RUN docker-php-ext-install pdo_mysql

# Ambil hasil dari stage sebelumnya (hanya file yang diperlukan)
COPY --from=backend-builder /var/www/vendor ./vendor
COPY --from=frontend-builder /app/public/build ./public/build
COPY . .

# Optimasi izin akses folder
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]