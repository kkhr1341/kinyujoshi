FROM php:7.3.2-apache-stretch

RUN apt-get update
RUN apt-get install -y git mysql-client libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev ssmtp mailutils

RUN docker-php-ext-install pdo_mysql mysqli gd iconv mbstring
# RUN docker-php-ext-install mysql pdo_mysql mysqli gd iconv mcrypt mbstring

#RUN pecl install xdebug-2.7.0
#RUN docker-php-ext-enable xdebug

# RUN cd /etc/apache2/mods-enabled \
#    && ln -s ../mods-available/rewrite.load \
#    && ln -s ../mods-available/headers.load \
#    && ln -s ../mods-available/expires.load

RUN a2enmod rewrite

WORKDIR /var/www/html

ADD composer.json .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filena

RUN composer.phar install