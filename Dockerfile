# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Mettre à jour les paquets et installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip git curl sudo cron \
    python3-certbot-apache \
    && docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite ssl \
    && apt-get clean

# Activer mod_rewrite dans Apache
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier les fichiers de l'application
COPY ./src /var/www/html

# Fixer les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/backend/client/uploads/photos \
    && chown -R www-data:www-data /var/www/html/backend/client/uploads \
    && chmod -R 775 /var/www/html/backend/client/uploads

# Copier l'entrée personnalisée
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exposer les ports 80 et 443
EXPOSE 80 443

# Démarrer via le script d'entrée
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
