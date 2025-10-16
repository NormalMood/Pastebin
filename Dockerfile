FROM php:8.4-apache

RUN apt-get update && apt-get install -y unzip git zip libzip-dev libpq-dev cron && docker-php-ext-install zip pdo_pgsql pgsql && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock /var/www/pastebin/
WORKDIR /var/www/pastebin
RUN composer install --no-dev --optimize-autoloader

COPY . /var/www/pastebin
COPY config/pastebin.conf /etc/apache2/sites-available/000-default.conf
COPY config/php.ini /usr/local/etc/php/php.ini

RUN a2enmod rewrite

RUN echo "ServerName 188.225.78.31" >> /etc/apache2/apache2.conf

COPY cron/delete_expired_posts.txt /etc/cron.d/delete_expired_posts
RUN chmod 0644 /etc/cron.d/delete_expired_posts
RUN crontab /etc/cron.d/delete_expired_posts



EXPOSE 80

CMD ["bash", "-c", "cron -f & apache2-foreground"]