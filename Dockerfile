FROM php:8.3-apache

ENV PHP_MEMORY_LIMIT=512M
ENV PHP_MAX_EXECUTION_TIME=300
ENV PHP_POST_MAX_SIZE=100M
ENV PHP_UPLOAD_MAX_FILESIZE=100M
ENV PHP_MAX_FILE_UPLOADS=20
ENV PHP_MAX_INPUT_VARS=1000
ENV PHP_DISPLAY_ERRORS=Off
ENV PHP_ERROR_REPORTING="E_ALL & ~E_DEPRECATED & ~E_STRICT"
ENV PHP_LOG_ERRORS=On
ENV PHP_ERROR_LOG="/dev/stderr"
ENV PHP_DATE_TIMEZONE="Asia/Kathmandu"

RUN apt update && apt install -y \
    git \
    unzip \
    vim \
    curl \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev

RUN docker-php-ext-install bcmath pdo_mysql mbstring exif pcntl gd intl zip

ENV APACHE_DOCUMENT_ROOT="/var/www/html/public"
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --no-interaction -o --ansi

RUN mkdir -p storage/framework/{sessions,views,cache}

RUN chgrp -R www-data storage bootstrap/cache

RUN chmod -R ug+rwx storage bootstrap/cache

RUN php artisan storage:link

CMD apachectl -D FOREGROUND
