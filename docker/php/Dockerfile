FROM php:8.2.0-fpm

RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www/app

RUN chown -R www:www /var/www/app

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    curl \
    unzip \
    gnupg

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install zip \
    pdo \
    pdo_pgsql \
    pgsql

USER www

EXPOSE 9000

CMD bash -c "\
    composer install && \
    if [ ! -f config/jwt/private.pem ]; then php bin/console lexik:jwt:generate-keypair; fi && \
    y | php bin/console d:m:m && \
    php-fpm \
"