FROM php:8.2-fpm-alpine

ARG WWWUSER=1000
ARG WWWGROUP=1000

RUN apk add --no-cache \
    git curl zip unzip bash icu-dev oniguruma-dev libpng libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
    libzip-dev zlib-dev autoconf make g++ openssl

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j$(nproc) pdo_mysql bcmath exif pcntl intl gd zip opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 🔧 tworzenie usera/grupy – jeśli GID już istnieje, użyj istniejącej grupy
RUN set -eux; \
    if getent group "${WWWGROUP}" >/dev/null 2>&1; then \
        EXISTING_GROUP="$(getent group ${WWWGROUP} | cut -d: -f1)"; \
        adduser -D -u "${WWWUSER}" -G "${EXISTING_GROUP}" appuser; \
    else \
        addgroup -g "${WWWGROUP}" appgroup; \
        adduser -D -u "${WWWUSER}" -G appgroup appuser; \
    fi; \
    mkdir -p /tmp/composer /var/www/html; \
    chown -R appuser: /tmp/composer /var/www

ENV COMPOSER_CACHE_DIR=/tmp/composer
WORKDIR /var/www/html
USER appuser
