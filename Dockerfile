ARG PHP_VERSION=8.2
FROM php:${PHP_VERSION}-cli-bookworm

RUN <<-EOF
    docker-php-ext-enable opcache

    PHP_VERSION=$(php -v | grep -oP '(?<=PHP )\d+\.\d+')

    if [[ $PHP_VERSION < "8.4" ]]; then
    apt-get update
	apt-get install -y autoconf pkg-config
	pecl channel-update pecl.php.net
	pecl install xdebug
        docker-php-ext-enable xdebug
    fi
EOF

RUN <<-EOF
	cat <<-SHELL >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
	xdebug.client_host=host.docker.internal
	xdebug.mode=develop
	xdebug.start_with_request=yes
	SHELL

	cat <<-SHELL >> /usr/local/etc/php/conf.d/php.ini
	display_errors=On
	error_reporting=E_ALL
	date.timezone=UTC
	SHELL
EOF

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN <<-EOF
	apt-get update
	apt-get install unzip
	curl -s https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer | php -- --quiet
	mv composer.phar /usr/local/bin/composer
	cat <<-SHELL >> /root/.bashrc
	export PATH="$HOME/.composer/vendor/bin:$PATH"
	SHELL
EOF

RUN composer global require squizlabs/php_codesniffer

ENV COMPOSER_ROOT_VERSION 6.0.0
