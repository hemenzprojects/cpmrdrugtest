# Use PHP 7.4 with Apache
FROM php:7.4-apache

# Install required libraries for GD extension
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Set ServerName to localhost
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable mod_rewrite for Laravel
RUN a2enmod rewrite

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set Laravel's public directory as DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-enabled/000-default.conf

# Set working directory inside the container
WORKDIR /var/www/html

# Copy application files to the container
COPY . /var/www/html

# Ensure correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
