FROM php:8.4-apache

RUN apt-get update && apt-get install -y unzip git zip libzip-dev libpq-dev && docker-php-ext-install zip pdo_pgsql pgsql && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/pastebin
COPY pastebin.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /usr/local/etc/php/php.ini

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/pastebin
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80