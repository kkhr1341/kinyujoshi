FROM php:5.5-apache

RUN a2enmod rewrite

RUN apt-get update
RUN apt-get install -y mysql-client libfreetype6-dev libjpeg62-turbo-dev libpng12-dev libmcrypt-dev

RUN docker-php-ext-install mysql pdo_mysql mysqli gd iconv mcrypt mbstring

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY php.ini /usr/local/etc/php/