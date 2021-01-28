FROM php:8.0-fpm

RUN apt-get update && apt-get install -y git

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN usermod -u 1000 www-data

WORKDIR /var/www

EXPOSE 9000
