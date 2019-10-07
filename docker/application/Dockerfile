FROM php:fpm-stretch

# PHP extensions
RUN apt-get update && apt-get install -y mysql-client
RUN docker-php-ext-install pdo_mysql

# Kafka
#RUN apt-get install -y librdkafka-dev
#RUN pecl install rdkafka && docker-php-ext-enable rdkafka

RUN pecl install xdebug-2.7.1
RUN docker-php-ext-enable xdebug

ARG xdebug_remote_enable=0
ARG xdebug_remote_autostart=0
ARG xdebug_profiler_enable=0

RUN echo "xdebug.remote_enable=$xdebug_remote_enable" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_autostart=$xdebug_remote_autostart" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.profiler_enable=$xdebug_profiler_enable" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.profiler_output_dir='storage/profiling'" >> /usr/local/etc/php/php.ini

RUN groupadd -g 1001 www
RUN useradd -u 1001 -ms /bin/bash -g www -G www-data www
USER www

# Supervisor
#RUN apt-get install -y supervisor
#ADD docker/application/config/supervisor/supervisord.conf /etc/supervisord.conf
#ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]