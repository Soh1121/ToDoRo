FROM node:16-alpine as node
FROM nginx:1.20-alpine

ENV TZ=Asia/Tokyo

RUN apk update && \
  apk add --update --no-cache --virtual=.build-dependencies g++

# node command
COPY --from=node /usr/local/bin /usr/local/bin
# npm command
COPY --from=node /usr/local/lib /usr/local/lib
# yarn command
COPY --from=node /opt /opt
# nginx config file will be output to /etc/nginx/conf.d/ by envsubst
COPY ./docker/nginx/default.conf /etc/nginx/templates/default.conf.template
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

COPY ./web /work/web

WORKDIR /work/web

RUN apt-get update \
    && apt-get install --no-install-recommends -y wget git unzip libpq-dev \
    && : 'Install Node.js' \
    && curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && apt-get install --no-install-recommends -y nodejs \
    && npm install -g npm@latest \
    && : 'Install Vue CLI' \
    && npm install -g @vue/cli \
    && : 'build Vue' \
    && cd frontend \
    && npm ci \
    && npm run build \
    && cd ../ \
    && cp -r ./public /var/www/public \
    && rm -rf ./ \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www
