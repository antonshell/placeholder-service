FROM php:8.1-fpm

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install xsltproc for pslm html reports https://github.com/Roave/psalm-html-output
RUN apt-get update && apt-get install -y xsltproc

RUN apt-get update && apt-get install -y git

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

COPY ./php.ini /usr/local/etc/php/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

WORKDIR /var/www

EXPOSE 9000
