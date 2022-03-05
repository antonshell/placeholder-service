FROM php:8.0-alpine

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN apk add \
    git \
    freetype-dev \
    libjpeg-turbo-dev \
    libjpeg-turbo \
    libpng-dev \
    libzip-dev \
    zip \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd \
 && docker-php-ext-install zip

COPY . /var/www

WORKDIR /var/www

RUN mkdir -p -m 0770 temp \
 && chgrp www-data temp \
 && composer install -n --optimize-autoloader

USER www-data

EXPOSE 80

CMD ["php", "-c", "docker/standalone/php.ini", "-S", "0.0.0.0:80", "public/index.php"]
