FROM php:7.3-fpm

RUN apt-get update && \
    apt-get install -y git

COPY --from=composer /usr/bin/composer /usr/bin/composer

# install symfony CLI tool
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN apt-get clean

WORKDIR /var/www/app

CMD ["php-fpm"]
