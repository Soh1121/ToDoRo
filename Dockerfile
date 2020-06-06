FROM php:7.4.6-fpm

COPY install-composer.sh /
RUN apt-get update \
  && apt-get install --no-install-recommends -y wget git unzip libpq-dev \
  && : 'Install Node.js' \
  && curl -sL https://deb.nodesource.com/setup_12.x | bash - \
  && apt-get install --no-install-recommends -y nodejs \
  && npm install -g npm@latest \
  && : 'Install PHP Extensions' \
  && docker-php-ext-install -j$(nproc) pdo_pgsql \
  && : 'Install Composer' \
  && chmod 755 /install-composer.sh \
  && /install-composer.sh \
  && mv composer.phar /usr/local/bin/composer \
  && : 'Install Vue CLI' \
  && npm install -g @vue/cli \
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html/ToDoRo
