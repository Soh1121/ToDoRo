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
  && : 'Install Redis' \
  && pecl install redis-5.3.4 \
  && docker-php-ext-enable redis

COPY ./docker/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY --chown=www-data:www-data ./web /var/www

WORKDIR /var/www
