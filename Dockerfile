# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Mettre à jour les paquets et installer les extensions nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl unzip \
    && docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite dans Apache
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier les fichiers de l'application
COPY ./src /var/www/html

# Fixer les permissions (IMPORTANT)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/backend/client/uploads/photos \
    && chown -R www-data:www-data /var/www/html/backend/client/uploads \
    && chmod -R 775 /var/www/html/backend/client/uploads

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
