FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    apache2 cron sudo curl git zip unzip \
    python3-certbot-apache \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev \
  && docker-php-ext-install mysqli pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Autoriser .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier les sources
COPY ./src /var/www/html

# Copier le script d’entrée
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
