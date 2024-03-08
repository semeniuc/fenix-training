FROM php:8.3-fpm

RUN apt-get update  \
    && apt-get install -y git zip unzip wget pkg-config libpq-dev libxml2-dev libxslt1-dev libzip-dev libpng-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libxml2-dev \
    && apt-get clean \
    && apt-get autoclean

RUN docker-php-ext-install intl opcache bcmath pdo_mysql mysqli gd zip exif soap mbstring pcntl sockets xsl

RUN docker-php-ext-configure gd  \
    && docker-php-ext-configure zip

# apcu
RUN pecl install apcu && docker-php-ext-enable apcu

# xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d/

# other configs
COPY ./php.ini /usr/local/etc/php/conf.d/
COPY ./fpm.conf /usr/local/etc/pool.d/fpm.conf

RUN usermod -u 1000 www-data

WORKDIR /var/www/project