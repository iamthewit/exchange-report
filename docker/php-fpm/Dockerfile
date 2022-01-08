# docker/php-fpm/Dockerfile

# orignially from: https://www.devpowerup.com/php-docker

FROM php:8-fpm

# Get frequently used tools
RUN apt-get update && apt-get install -y \
    build-essential \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    unzip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl \
    wget \
    zsh

RUN docker-php-ext-configure zip

RUN docker-php-ext-install \
        bcmath \
        mbstring \
        pcntl \
        intl \
        zip \
        opcache \
        amqp

# apcu for caching, xdebug for debugging and also phpunit coverage
#RUN pecl install \
#        apcu-${APCU_VERSION} \
#        xdebug \
#    && docker-php-ext-enable \
#        apcu \
#        xdebug

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# php-cs-fixer tool
RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O /usr/local/bin/php-cs-fixer
RUN chmod +x /usr/local/bin/php-cs-fixer

# Copy existing app directory
COPY . /var/www
WORKDIR /var/www

# Copy and run composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install --no-interaction

EXPOSE 8080

CMD ["php-fpm"]