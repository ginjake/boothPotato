FROM php:8.1.8-apache
EXPOSE 5173
ENV DEBCONF_NOWARNINGS yes

RUN apt-get update \
    && apt-get install -y zip unzip vim less libpq-dev libzip* libjpeg* libpng* libfreetype6-dev \
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include --with-jpeg=/usr/include \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get -y update
RUN apt-get install -y \
    curl \
    gnupg
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

COPY php-base.ini $PHP_INI_DIR/conf.d/

COPY httpd-base.conf /etc/apache2/sites-available/laravel.conf
RUN a2dissite 000-default.conf && a2ensite laravel.conf && a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN /usr/local/bin/composer global require "laravel/envoy"

ENV PATH $PATH:/root/.composer/vendor/bin

RUN echo 'alias ll="ls -l"' >> ~/.bashrc
RUN echo 'alias la="ls -la"' >> ~/.bashrc
