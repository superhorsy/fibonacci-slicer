FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd 

RUN docker-php-ext-install pdo_mysql pdo mysqli

RUN apt-get install -y libmagickwand-dev --no-install-recommends && \
    pecl install imagick && docker-php-ext-enable imagick && \
    rm -rf /var/lib/apt/lists/*

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions imagick

RUN \
  curl 'http://pecl.php.net/get/redis-3.1.5.tgz' -o /tmp/redis-3.1.5.tgz  \
  && cd /tmp \
  && pecl install redis-3.1.5.tgz \
  && rm -rf redis-3.1.5.tgz \
  && docker-php-ext-enable redis \
