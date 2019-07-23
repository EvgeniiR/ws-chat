FROM php:7.2-fpm

COPY ./composer.json /var/www/html/composer.json

RUN apt-get update

RUN set -ex && \
    apt-get install vim -y && \
    apt-get install openssl -y && \
    apt-get install libssl-dev -y && \
    apt-get install wget -y && \
    apt-get install libpq-dev -y

RUN cd /tmp && wget https://pecl.php.net/get/swoole-4.2.9.tgz && \
    tar zxvf swoole-4.2.9.tgz && \
    cd swoole-4.2.9  && \
    phpize  && \
    ./configure  --enable-openssl && \
    make && make install

RUN touch /usr/local/etc/php/conf.d/swoole.ini && \
    echo 'extension=swoole.so' > /usr/local/etc/php/conf.d/swoole.ini

RUN docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html/

EXPOSE 8101
CMD ["/usr/local/bin/php", "/var/www/html/ws_start_server.php"]