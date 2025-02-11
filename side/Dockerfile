FROM php:8.3-fpm

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update -y
RUN apt-get -y install gcc make autoconf libc-dev pkg-config libzip-dev

RUN apt-get install -y --no-install-recommends \
	git \
	libz-dev \
	libpq-dev \
	libxml2-dev \
	libmemcached-dev \
	libldap2-dev libbz2-dev \
	zlib1g-dev libicu-dev g++ \
	libssl-dev libssl-doc libsasl2-dev \
	curl libcurl4-openssl-dev  \
	re2c libpng++-dev libwebp-dev libjpeg-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libvpx-dev libfreetype6-dev \ 
	libgmp-dev firebird-dev libib-util \ 
	python3-lib2to3 libmagick++-dev libmagickwand-dev \ 
	zlib1g-dev libgd-dev \
	unzip libpcre3 libpcre3-dev \
	sqlite3 libsqlite3-dev libxslt-dev \
	libtidy-dev libxslt1-dev libmagic-dev libexif-dev file \
	libmhash2 libmhash-dev libc-client-dev libkrb5-dev libssh2-1-dev \
	poppler-utils ghostscript libmagickwand-6.q16-dev libsnmp-dev libedit-dev libreadline6-dev libsodium-dev \
	freetds-bin freetds-dev freetds-common libct4 libsybdb5 tdsodbc libreadline-dev librecode-dev libpspell-dev libonig-dev 

RUN  rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_dblib
RUN docker-php-ext-install dba
RUN docker-php-ext-install ldap
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install bz2
RUN docker-php-ext-install calendar
RUN docker-php-ext-install ctype
RUN docker-php-ext-install curl
RUN docker-php-ext-install dom
RUN docker-php-ext-install filter
RUN docker-php-ext-install exif
RUN docker-php-ext-install ftp
RUN docker-php-ext-install gettext
RUN docker-php-ext-install gmp
RUN docker-php-ext-install iconv
RUN docker-php-ext-install intl
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pspell
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install phar
RUN docker-php-ext-install posix
RUN docker-php-ext-install session
RUN docker-php-ext-install shmop
RUN docker-php-ext-install simplexml
RUN docker-php-ext-install soap
RUN docker-php-ext-install sockets
RUN docker-php-ext-install sodium
RUN docker-php-ext-install sysvmsg
RUN docker-php-ext-install sysvsem
RUN docker-php-ext-install sysvshm
RUN docker-php-ext-install snmp
RUN docker-php-ext-install tidy
RUN docker-php-ext-install zip
RUN docker-php-ext-install xsl
RUN docker-php-ext-install xml
RUN docker-php-ext-configure gd --with-freetype --with-jpeg 
RUN docker-php-ext-install -j$(nproc) gd

COPY . /var/www/app

WORKDIR /var/www/app 
RUN chown -R www-data:www-data /var/www/app
RUN chmod 755 /var/www
USER www-data

RUN composer update && composer dump-autoload
RUN php artisan key:generate && php artisan storage:link


EXPOSE 9000

CMD ["php-fpm"]