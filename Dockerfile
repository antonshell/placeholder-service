# syntax=docker/dockerfile:1
#
# Targets:
#   dev   — local development and CI tests (docker compose), code is bind-mounted, xdebug included
#   prod  — production image (default target), code baked in

# ---------- Base: FrankenPHP (PHP + Caddy in one binary) ----------
# PHP 8.3: the locked vimeo/psalm 5.x doesn't install on newer PHP
FROM dunglas/frankenphp:1-php8.3-bookworm AS base

# gd is built with FreeType + libjpeg (text rendering, JPEG output)
RUN install-php-extensions gd zip apcu opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Headers for static files served directly by Caddy (responses from Symfony set their own Cache-Control).
COPY <<EOF /etc/frankenphp/static-headers.caddy
@icons path /favicon.ico
header @icons Cache-Control "public, max-age=604800"
EOF

# Plain HTTP on 8080 — TLS is terminated by the external Caddy (prod) or not needed (dev)
ENV SERVER_NAME=:8080 \
    CADDY_SERVER_EXTRA_DIRECTIVES="import /etc/frankenphp/static-headers.caddy"

WORKDIR /app

EXPOSE 8080

# ---------- Dev ----------
FROM base AS dev

# xsltproc: psalm html report (composer psalm-report-html)
RUN apt-get update \
    && apt-get install -y --no-install-recommends xsltproc \
    && rm -rf /var/lib/apt/lists/* \
    && install-php-extensions xdebug \
    && cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    # allow running as the host user (see `user:` in docker-compose.yml)
    && chmod -R a+rwX /data /config

COPY <<EOF $PHP_INI_DIR/conf.d/zz-dev.ini
memory_limit = 2G
max_execution_time = 300
xdebug.client_host = host.docker.internal
xdebug.start_with_request = trigger
xdebug.log_level = 0
; php.ini-development sets "GPCS": keep E so tests see DOCKER_ENVIRONMENT in \$_ENV
variables_order = "EGPCS"
EOF

# Writable home for the composer cache when running as an arbitrary UID.
# DOCKER_ENVIRONMENT: tests compare generated images with resources/test_images_docker.
# No APP_ENV here: with "EGPCS" it would land in $_ENV and override APP_ENV=test of phpunit (dev comes from .env).
ENV HOME=/tmp \
    XDEBUG_MODE=coverage \
    DOCKER_ENVIRONMENT=true

# ---------- Prod (default target — keep it last) ----------
FROM base AS prod

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY <<EOF $PHP_INI_DIR/conf.d/zz-prod.ini
expose_php = Off
memory_limit = 256M
max_execution_time = 30

opcache.enable = 1
opcache.memory_consumption = 128
opcache.max_accelerated_files = 20000
opcache.validate_timestamps = 0
realpath_cache_size = 4096K
realpath_cache_ttl = 600
EOF

ENV APP_ENV=prod \
    APP_DEBUG=0 \
    COMPOSER_ALLOW_SUPERUSER=1

# Dependencies first for better layer caching
COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

COPY . .

RUN composer dump-autoload --no-dev --classmap-authoritative \
    && php bin/console cache:clear --no-warmup \
    && php bin/console cache:warmup \
    && mkdir -p var \
    && chown -R www-data:www-data var /data/caddy /config/caddy

USER www-data

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD php -r 'exit(@file_get_contents("http://127.0.0.1:8080/") === false ? 1 : 0);'
