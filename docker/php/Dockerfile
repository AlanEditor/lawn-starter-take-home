FROM php:8.4-fpm-alpine

ARG USER_ID=1000

RUN apk update && apk upgrade && apk add --no-cache \
    git \
    curl \
    libxml2-dev \
    zip \
    unzip \
    icu-dev \
    mariadb-connector-c-dev \
    zlib-dev \
    libzip-dev \
    autoconf \
    # Inclui o compilador C, make, etc. (Resolve o erro "no acceptable C compiler found")
    build-base \
    # Inclui as ferramentas de desenvolvimento do PHP (phpize, headers, etc.)
    php84-dev \
    && rm -rf /var/cache/apk/*

# 2. Instalação de Extensões PHP
RUN docker-php-ext-install pdo_mysql opcache zip intl

# 3. Instalação da extensão Redis (via PECL)
RUN pecl install redis \
    && docker-php-ext-enable redis

RUN rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN deluser www-data
RUN adduser -D -u $USER_ID www-data # Cria o usuário www-data com o UID do host

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

USER www-data

CMD ["php-fpm"]