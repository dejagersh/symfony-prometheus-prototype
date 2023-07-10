ARG PHP_VERSION=8.2
ARG NODE_VERSION=18
FROM fideloper/fly-laravel:${PHP_VERSION} as base

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION

LABEL fly_launch_runtime="laravel"

# copy application code, skipping files based on .dockerignore
COPY . /var/www/html

RUN composer install --optimize-autoloader \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data /var/www/html \
    && cp .fly/entrypoint.sh /entrypoint \
    && cp .fly/FlySymfonyRuntime.php /var/www/html/src/FlySymfonyRuntime.php \
    && rm /etc/nginx/sites-enabled/default && rsync -avz .fly/nginx/* /etc/nginx/ \
    && chmod +x /entrypoint

RUN chown -R www-data:www-data /var/www/html/public

EXPOSE 8080

ENTRYPOINT ["/entrypoint"]
