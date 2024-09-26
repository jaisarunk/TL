# Use the official PHP image with FPM (FastCGI Process Manager)
FROM php:8.1-fpm

# Set the working directory in the container
WORKDIR /var/www

# Copy the current directory contents into the container
COPY . .

# Install system dependencies and enable PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel application dependencies
RUN composer install

# Copy the existing local environment file to the container (if it exists)
COPY .env.example .env

# Generate the Laravel application key (required by Laravel)
RUN php artisan key:generate

# Run Laravel migrations (for initializing the database schema)
#RUN php artisan migrate --force

# Expose port 8000 to the host
EXPOSE 8000

# Run the Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000
