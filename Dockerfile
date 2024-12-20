FROM php:8.1-fpm-alpine

# Install necessary extensions
RUN apk update && apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project files
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install

CMD ["php-fpm"]
