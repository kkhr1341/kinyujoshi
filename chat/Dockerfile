FROM php:7.3.2-apache-stretch

RUN apt-get update
RUN apt-get install -y git mysql-client libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev ssmtp mailutils

RUN docker-php-ext-install pdo_mysql mysqli gd iconv mbstring

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filena

COPY app /var/www/html

RUN composer.phar install

#CMD ["php" ,"bin/chat-server.php"]