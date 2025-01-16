FROM php:8.2-apache

RUN apt update && apt install -y git

RUN docker-php-ext-install mysqli pdo pdo_mysql sockets \
    && a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
