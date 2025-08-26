# Symfony 3.4 + PHP 7.4 (serveur PHP intégré)
FROM php:7.4-cli

# Dépendances pour extensions PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libzip-dev libpng-dev git unzip && \
    docker-php-ext-install intl zip pdo pdo_mysql mbstring gd opcache && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Composer (depuis l'image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Code source
COPY . /app

# Dossiers d'écriture (Symfony 3.4)
RUN mkdir -p var/cache var/logs app/cache app/logs && \
    chown -R www-data:www-data var app && chmod -R 775 var app

# Install prod
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1
RUN composer install -n --no-dev --prefer-dist --optimize-autoloader

# Kinsta fournit $PORT (ex: 8080)
EXPOSE 8080
CMD sh -c 'php -S 0.0.0.0:${PORT:-8080} -t web web/app.php'
