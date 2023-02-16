# The base image which has php8.2-fpm and nginx
FROM webdevops/php-nginx:8.2

# Set image metadata
LABEL version="1.0"
LABEL description="Laravel ExA"

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
    git \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_mysql zip pgsql pdo pdo_pgsql gd \
    && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

RUN echo output_buffering = 4096 >> /opt/docker/etc/php/php.ini
RUN echo implicit_flush = Off >> /opt/docker/etc/php/php.ini
RUN echo max_execution_time = 600 >> /opt/docker/etc/php/php.ini
RUN echo max_input_time = 60 >> /opt/docker/etc/php/php.ini
RUN echo memory_limit = 256M >> /opt/docker/etc/php/php.ini
RUN echo register_argc_argv = Off >> /opt/docker/etc/php/php.ini
RUN echo post_max_size = 80M >> /opt/docker/etc/php/php.ini
RUN echo upload_max_filesize = 64M >> /opt/docker/etc/php/php.ini

# Copy our source code into the container
COPY --chown=www-data:www-data . /var/www
COPY .env .env

# Install dependencies
RUN composer install --prefer-dist && rm -rf /root/.composer

# Finish composer
RUN composer dump-autoload

RUN chmod -R 777 /var/www/storage/

# Mark WORKDIR as safe for GIT
RUN git config --global --add safe.directory /var/www

EXPOSE 80
EXPOSE 443
