# The base image which has php8.2-fpm and nginx
FROM webdevops/php-nginx:8.2-alpine

# Set image metadata
LABEL version="1.0"
LABEL description="Laravel ExA"

# Set the web root from which nginx serves our app
ENV WEB_DOCUMENT_ROOT="/var/www/public"

RUN if [ ${M1_PROCESSOR} = true ]; then \
    wget -O "/usr/local/bin/go-replace" "https://github.com/webdevops/goreplace/releases/download/1.1.2/gr-arm64-linux" \
        && chmod +x "/usr/local/bin/go-replace" \
        && "/usr/local/bin/go-replace" --version \
;fi

# Install various packages, php extensions and composer
RUN set -x && apk-install \
    libmcrypt-dev \
    mariadb-client \
    libpq-dev \
    htop \
    && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# XDebug
RUN if [ ${XDEBUG_ENABLED} = true ]; then \
  pecl install xdebug && docker-php-ext-enable xdebug \
;fi
COPY ./docker/app/config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www

RUN echo output_buffering = 4096 >> /opt/docker/etc/php/php.ini \
    && echo implicit_flush = Off >> /opt/docker/etc/php/php.ini \
    && echo max_execution_time = 600 >> /opt/docker/etc/php/php.ini \
    && echo max_input_time = 60 >> /opt/docker/etc/php/php.ini \
    && echo memory_limit = 256M >> /opt/docker/etc/php/php.ini \
    && echo register_argc_argv = Off >> /opt/docker/etc/php/php.ini \
    && echo post_max_size = 80M >> /opt/docker/etc/php/php.ini \
    && echo upload_max_filesize = 64M >> /opt/docker/etc/php/php.ini

# Copy our source code into the container
COPY --chown=www-data:www-data . /var/www
COPY .env .env

# Install dependencies
RUN composer install --prefer-dist && rm -rf /root/.composer

# Finish composer
RUN composer dump-autoload

RUN chmod -R 775 /var/www/storage/
RUN chmod -R 775 /var/www/bootstrap/cache/

# Mark WORKDIR as safe for GIT
RUN git config --global --add safe.directory /var/www

EXPOSE 80
EXPOSE 443
