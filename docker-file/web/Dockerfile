FROM php:8.2-apache

# Copy custom php.ini configuration
COPY php.ini /usr/local/etc/php/

# Install necessary packages including Ghostscript
RUN apt-get update \
  && apt-get install --no-install-recommends -y \
      git \
      curl \
      wget \
      sudo \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libmcrypt-dev \
      libxml2-dev \
      libpq-dev \
      libzip-dev \
      libpq5 \
      postgresql-client \
      default-mysql-client \
      libicu-dev \
      libonig-dev \
      libmagickwand-dev \
      ghostscript \
      inkscape \
      imagemagick \
  && mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled \
  && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
  && docker-php-ext-install -j$(nproc) zip gd xml pdo pdo_mysql mysqli soap intl \
  && pecl install imagick \
  && docker-php-ext-enable imagick \
  && rm -r /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache rewrite module
RUN /bin/sh -c a2enmod rewrite
