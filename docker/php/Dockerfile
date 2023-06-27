FROM php:8.1-fpm-alpine as app

# php util
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin
RUN set -eux; \
    install-php-extensions pdo pdo_mysql

# composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./app/composer.* ./
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction
COPY ./app ./
RUN composer dump-autoload --optimize

#--- dev

FROM app as app_dev
# ENV XDEBUG_MODE=debug
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN set -eux; \
    install-php-extensions xdebug