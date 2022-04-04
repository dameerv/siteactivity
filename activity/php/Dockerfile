FROM php:8.0-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev wget

RUN rm -rf /var/www && mkdir -p /var/www/activity
WORKDIR /var/www/activity/

COPY . /var/www/activity/


RUN wget https://getcomposer.org/download/2.3.3/composer.phar \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

#RUN composer install

