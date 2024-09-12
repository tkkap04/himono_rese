FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmagickwand-dev --no-install-recommends \
    cron \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo pdo_mysql

RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
ENV TZ Asia/Tokyo

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

COPY crontab /etc/cron.d/laravel-cron
RUN chmod 644 /etc/cron.d/laravel-cron
RUN crontab /etc/cron.d/laravel-cron

CMD ["sh", "-c", "cron && php-fpm"]

WORKDIR /var/www