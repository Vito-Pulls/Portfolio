FROM php:8.2-apache

# Extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración de Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Copiar código de la app
COPY . /var/www/html/

# Permisos para uploads
RUN mkdir -p /var/www/html/assets/uploads \
    && chown -R www-data:www-data /var/www/html/assets/uploads \
    && chmod 755 /var/www/html/assets/uploads

# PHP config personalizada
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

EXPOSE 80