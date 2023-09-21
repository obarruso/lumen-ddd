FROM php:8.2-apache

COPY .docker/debug/xdebug.ini "/usr/local/etc/php/conf.d"

RUN pecl install xdebug \
    && apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app

RUN chown -R www-data:www-data /var/www \
    && a2enmod rewrite

RUN groupadd -g 1000 -r user  && useradd -r -u 1000 -g user user
USER user
