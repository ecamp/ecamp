# includes apache, php, composer, xdebug + several php extensions
FROM chialab/php-dev:7.4-apache 

# switch document root
ENV APACHE_DOCUMENT_ROOT=/app/src/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# increase max execution time
RUN echo 'max_execution_time = 240' >> /usr/local/etc/php/conf.d/docker-php-maxexectime.ini;

# limit memory to 16MB (same as production value in .user.ini)
RUN echo 'memory_limit = 16M' >> /usr/local/etc/php/conf.d/docker-php-memorylimit.ini;

# display all errors
RUN echo 'error_reporting = E_ALL & ~E_NOTICE' >> /usr/local/etc/php/conf.d/error-logging.ini