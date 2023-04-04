FROM php:8.1-cli-alpine

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN apk add gcc make autoconf libc-dev \
	&& pecl install apcu \
	&& docker-php-ext-enable apcu

WORKDIR /app

USER app
