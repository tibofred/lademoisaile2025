# Symfony 3.4 + PHP 7.4
FROM php:7.4-cli

# 1) Paquets système pour extensions PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    git unzip ca-certificates openssh-client && \
    rm -rf /var/lib/apt/lists/*

# 2) Extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" intl zip pdo_mysql mbstring gd opcache

# 3) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# (Optionnel) Passer un token GitHub au build si dépôts privés :
# docker build --build-arg GITHUB_TOKEN=ghp_XXXXX ...
ARG GITHUB_TOKEN
RUN if [ -n "$GITHUB_TOKEN" ]; then composer config -g github-oauth.github.com "$GITHUB_TOKEN"; fi

# 4) Meilleur cache : installer d'abord les deps via lock
COPY composer.json composer.lock /app/
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1 \
    APP_ENV=prod SYMFONY_ENV=prod

# IMPORTANT : on évite les scripts au build
RUN composer install -n --no-dev --prefer-dist --no-scripts -vvv || (echo 'Composer failed (deps)'; exit 1)

# 5) Copier le code
COPY . /app

# 6) Autoload optimisé (toujours sans scripts)
RUN composer dump-autoload -o -vvv || (echo 'Composer failed (autoload)'; exit 1)

# 7) Permissions Symfony 3.4
RUN mkdir -p var/cache var/logs app/cache app/logs web && \
    chown -R www-data:www-data var app && chmod -R 775 var app

# 8) Exposer le port runtime Kinsta
EXPOSE 8080
# NB: on NE lance pas de cache:clear au build (souvent source d'erreurs).
# On sert l'app via le serveur PHP intégré :
CMD sh -c 'php -S 0.0.0.0:${PORT:-8080} -t web web/app.php'
