FROM php:7-fpm

# PHP extensions
RUN apt-get update
RUN docker-php-ext-install pdo_mysql

# Kafka
RUN apt-get install -y librdkafka-dev
RUN pecl install rdkafka && docker-php-ext-enable rdkafka

# Supervisor
#RUN apt-get install -y supervisor
#COPY docker/app/config/supervisord.conf /etc/supervisor/supervisord.conf
#COPY docker/app/config/supervisor.d /etc/supervisor/conf.d
#ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]