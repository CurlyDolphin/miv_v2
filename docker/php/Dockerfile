FROM php:8.2-fpm

# Устанавливаем зависимости для работы с PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev

# Устанавливаем зависимости для intl
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Устанавливаем расширения PDO и pdo_pgsql
RUN docker-php-ext-install pdo pdo_pgsql

# Устанавливаем и включаем opcache
RUN docker-php-ext-install opcache

# Устанавливаем Xdebug
ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug && \
    docker-php-ext-enable xdebug \
;fi

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Настройка рабочего окружения
WORKDIR /var/www/html

# Копируем пользовательские настройки PHP
COPY php.ini /usr/local/etc/php/
