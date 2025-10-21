FROM php:8.2-apache

WORKDIR /var/www/html

COPY index.php /var/www/html/
COPY php.ini /usr/local/etc/php/conf.d/php.ini

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80
