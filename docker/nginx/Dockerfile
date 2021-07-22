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
# nginx config file
COPY ./docker/nginx/*.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www