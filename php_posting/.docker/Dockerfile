FROM php:7.4.0alpha2-fpm

# Install Postgre PDO
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# Install xdebug - only dor dev purposes
#RUN pecl install xdebug-2.8.0alpha1 \
#    && docker-php-ext-enable xdebug

CMD ["php-fpm"]