# The base image which has php8.2-fpm and nginx
FROM webdevops/php-nginx:8.2

# Set image metadata
LABEL version="1.0"
LABEL description="TRACKSTREET API"

# Set the web root from which nginx serves our app
ENV WEB_DOCUMENT_ROOT="/var/www/public"

# Install various packages, php extensions and composer
RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    mariadb-client \
    zip \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    cron \
    htop \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_mysql zip pgsql pdo pdo_pgsql gd \
    && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Copy our source code into the container
COPY --chown=www-data:www-data . /var/www

# Install dependencies
RUN composer install --prefer-dist && rm -rf /root/.composer

# Finish composer
RUN composer dump-autoload

RUN chmod -R 777 /var/www/storage/

EXPOSE 80
