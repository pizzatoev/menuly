FROM php:8.2-apache

# Instala dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# Habilita mod_rewrite para Laravel
RUN a2enmod rewrite

# Copia archivos del proyecto Laravel
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia la configuración de Apache para apuntar a /public
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Da permisos y prepara carpetas necesarias
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Instala Composer (desde la imagen oficial)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Corre Composer, limpia config y genera clave de Laravel
# Paso 1: Instalar dependencias
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Paso 2: Dar permisos
RUN chmod -R 775 storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

# Paso 3: Limpiar configuración (requiere .env o vars en Render)
RUN php artisan config:clear

# Paso 4: Generar clave de la app (requiere .env o APP_KEY vacío)
RUN php artisan key:generate

