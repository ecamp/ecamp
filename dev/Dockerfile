# includes apache, php, composer, xdebug + several php extensions
FROM chialab/php-dev:7.1-apache 

# switch document root
ENV APACHE_DOCUMENT_ROOT=/app/www
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf