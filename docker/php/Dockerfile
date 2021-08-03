FROM php:7.4.6-fpm

ENV TZ=Asia/Tokyo

COPY ./docker/php/install-composer.sh /
RUN apt-get update \
  && apt-get install --no-install-recommends -y wget git unzip libpq-dev \
  && : 'Install Node.js' \
  && curl -sL https://deb.nodesource.com/setup_12.x | bash - \
  && apt-get install --no-install-recommends -y nodejs \
  && npm install -g npm@latest \
  && : 'Install PHP Extensions' \
  && docker-php-ext-install -j$(nproc) pdo_mysql \
  && : 'Install Composer' \
  && chmod 755 /install-composer.sh \
  && /install-composer.sh \
  && mv composer.phar /usr/local/bin/composer \
  && : 'Install Vue CLI' \
  && npm install -g @vue/cli \
  && mkdir /var/run/php-fpm \
  && rm -rf /var/lib/apt/lists/*

COPY ./docker/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
# COPY --chown=www-data:www-data ./web /var/www

# WORKDIR /var/www
# WORKDIR /work/web

# RUN composer install -n --prefer-dist --no-dev \
#   && cd ./frontend \
#   && npm ci \
#   && npm run build

# COPY --chown=www-data:www-data ./web /work/web

WORKDIR /work/web
