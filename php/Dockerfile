FROM php:5.6-apache

RUN a2enmod rewrite

RUN apt-get update
RUN apt-get install -y mysql-client libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev ssmtp mailutils

RUN docker-php-ext-install mysql pdo_mysql mysqli gd iconv mcrypt mbstring

RUN pecl install xdebug-2.4.0
RUN docker-php-ext-enable xdebug

# image magic
RUN apt-get install -y libmagickwand-dev --no-install-recommends
RUN pecl install imagick
RUN docker-php-ext-enable imagick

COPY php.ini /usr/local/etc/php/

COPY ssmtp.conf /etc/ssmtp/
