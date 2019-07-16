FROM php:7.4.0alpha2-fpm

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        unzip \
        wget \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install exif

RUN wget https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-amd64-static.tar.xz \
    && tar Jxvf ./ffmpeg-release-amd64-static.tar.xz \
    && cp ./ffmpeg*amd64-static/ffmpeg /usr/local/bin/

# Install xdebug - only dor dev purposes
#RUN pecl install xdebug-2.8.0alpha1 \
#    && docker-php-ext-enable xdebug

CMD ["php-fpm"]
