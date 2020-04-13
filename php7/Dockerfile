FROM composer:1.6
FROM php:7.4-fpm-alpine

ARG api_version=ed3dfdf0

RUN apk add --no-cache git

ENV APCU_VERSION 5.1.17
RUN set -xe \
	&& apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		libzip-dev \
		icu-dev \
		postgresql-dev \
		zlib-dev \
		libpng-dev \
		openssh \
		sshpass \
		supervisor \
	&& docker-php-ext-install \
		intl \
		pdo_pgsql \
		zip \
		gd \
	&& pecl install \
		apcu-${APCU_VERSION} \
	&& docker-php-ext-enable --ini-name 20-apcu.ini apcu \
	&& docker-php-ext-enable --ini-name 05-opcache.ini opcache \
	&& runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)" \
	&& apk add --no-cache --virtual .php-phpexts-rundeps $runDeps \
	&& apk del .build-deps

COPY --from=0 /usr/bin/composer /usr/bin/composer
COPY ./php7/php.ini /usr/local/etc/php/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative

WORKDIR /var/www/symfony

#COPY ./api/composer.json ./api/composer.lock ./
#RUN composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest \
#	&& composer clear-cache

RUN apk add --update supervisor \
    && rm  -rf /tmp/* /var/cache/apk/*
RUN apk add tzdata

#COPY ./api/. ./
RUN echo ${api_version::8} > ./VERSION
COPY ./php7/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
COPY ./php7/supervisord.conf /etc/supervisord.conf
COPY ./php7/crontab.txt /etc/crontab.txt
RUN cp /usr/share/zoneinfo/Poland /etc/localtime
RUN echo "Europe/Warsaw" >  /etc/timezone
RUN printf '[PHP]\ndate.timezone = "Europe/Warsaw"\n' > /usr/local/etc/php/conf.d/tzone.ini

RUN /usr/bin/crontab /etc/crontab.txt

#RUN mkdir -p var/cache var/logs var/sessions \
#	&& composer dump-autoload --classmap-authoritative --no-dev \
#	&& chown -R www-data var

CMD ["/usr/bin/supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]

ENTRYPOINT ["docker-entrypoint"]
