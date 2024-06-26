# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala las dependencias necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    zip \
    unzip

# Instala las extensiones PHP necesarias para Laravel y PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . .

# Copia el archivo .env
COPY .env.example .env

# Configura Composer para evitar advertencias y errores de seguridad
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

# Instala las dependencias de Composer y optimiza el autoloader
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Establece permisos para el almacenamiento de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Establece permisos para todos los archivos y directorios
RUN chmod -R 755 /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configura Apache para usar la carpeta public como DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

# Reinicia Apache para aplicar las configuraciones
RUN service apache2 restart

# Ejecuta los comandos de Artisan
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Expone el puerto 80
EXPOSE 80
