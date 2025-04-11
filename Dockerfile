FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    apache2 cron sudo curl git zip unzip \
    python3-certbot-apache \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev \
  && docker-php-ext-install mysqli pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Corriger Apache pour permettre .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY ./src /var/www/html

# Permissions des dossiers upload
RUN mkdir -p /var/www/html/backend/client/uploads/photos \
  && chown -R www-data:www-data /var/www/html \
  && chmod -R 775 /var/www/html/backend/client/uploads

# Script d’entrée personnalisé
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
