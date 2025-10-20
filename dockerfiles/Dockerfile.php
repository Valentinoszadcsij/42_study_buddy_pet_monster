FROM php:8.1-fpm
COPY ../php.ini /usr/local/etc/php/php.ini
RUN apt-get update && apt-get install -y \
    git zip unzip \
    default-mysql-client \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    sendmail \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

CMD ["php-fpm"]
