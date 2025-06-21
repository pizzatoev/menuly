FROM php:8.2-apache

# Instala dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia archivos
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia archivo de configuración de Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Da permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias Laravel
RUN composer install \
    && php artisan key:generate

EXPOSE 80
