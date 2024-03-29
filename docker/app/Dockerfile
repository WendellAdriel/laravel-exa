FROM webdevops/php-nginx:8.3-alpine
ENV WEB_DOCUMENT_ROOT="/var/www/public"

ARG M1_PROCESSOR
ENV M1_PROCESSOR $M1_PROCESSOR

RUN if [ ${M1_PROCESSOR} = true ]; then \
    wget -O "/usr/local/bin/go-replace" "https://github.com/webdevops/goreplace/releases/download/1.1.2/gr-arm64-linux" \
        && chmod +x "/usr/local/bin/go-replace" \
        && "/usr/local/bin/go-replace" --version \
;fi

RUN set -x && apk-install $PHPIZE_DEPS \
    libmcrypt-dev \
    mariadb-client \
    libpq-dev \
    htop \
    linux-headers \
    && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

ARG XDEBUG_ENABLED
ENV XDEBUG_ENABLED $XDEBUG_ENABLED

RUN if [ ${XDEBUG_ENABLED} = true ]; then \
  pecl install xdebug && docker-php-ext-enable xdebug \
;fi
COPY ./docker/app/config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www
COPY --chown=www-data:www-data . /var/www

RUN echo output_buffering = 4096 >> /opt/docker/etc/php/php.ini \
    && echo implicit_flush = Off >> /opt/docker/etc/php/php.ini \
    && echo max_execution_time = 600 >> /opt/docker/etc/php/php.ini \
    && echo max_input_time = 60 >> /opt/docker/etc/php/php.ini \
    && echo memory_limit = 256M >> /opt/docker/etc/php/php.ini \
    && echo register_argc_argv = Off >> /opt/docker/etc/php/php.ini \
    && echo post_max_size = 80M >> /opt/docker/etc/php/php.ini \
    && echo upload_max_filesize = 64M >> /opt/docker/etc/php/php.ini \
    && composer install --prefer-dist \
    && rm -rf /root/.composer \
    && composer dump-autoload \
    && chmod -R 775 /var/www/storage/ \
    && chmod -R 775 /var/www/bootstrap/cache/ \
    && git config --global --add safe.directory /var/www

EXPOSE 80
EXPOSE 443
