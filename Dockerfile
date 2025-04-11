FROM php:8.2-apache

WORKDIR /var/www/html

# Installer Apache, Certbot et dépendances
RUN apt-get update && apt-get install -y \
    apache2 cron sudo curl git zip unzip \
    python3-certbot-apache \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev \
  && docker-php-ext-install mysqli pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Autoriser .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier le code de l’application
COPY ./src /var/www/html

# Créer et corriger les permissions du dossier d’upload
RUN mkdir -p /var/www/html/backend/client/uploads/photos \
  && chown -R www-data:www-data /var/www/html \
  && chmod -R 775 /var/www/html/backend/client/uploads

# Copier et activer le script d’entrée
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exposer les ports
EXPOSE 80 443

# Lancer le script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
