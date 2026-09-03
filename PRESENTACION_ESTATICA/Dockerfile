FROM php:8.2-apache

# Habilitar módulos comunes de Apache
RUN a2enmod rewrite

# Instalar la extensión PDO MySQL necesaria para tu base de datos
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar el código del proyecto al directorio público de Apache
COPY . /var/www/html/

# Dar permisos a Apache para leer los archivos
RUN chown -R www-data:www-data /var/www/html/
