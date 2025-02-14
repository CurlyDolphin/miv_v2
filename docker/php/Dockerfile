FROM php:8.2-fpm

# Устанавливаем зависимости для работы с PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev

# Устанавливаем расширения PDO и pdo_pgsql
RUN docker-php-ext-install pdo pdo_pgsql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочего окружения
WORKDIR /var/www/html

# Установка Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Копируем пользовательские настройки PHP
COPY php.ini /usr/local/etc/php/
