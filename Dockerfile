# Utiliser l'image PHP avec Apache
FROM php:8.2-apache

# Définir le répertoire de travail pour l'application
WORKDIR /var/www/html

# Mettre à jour les paquets et installer les extensions nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends curl unzip && \
    docker-php-ext-install mysqli pdo_mysql && \
    a2enmod rewrite && \
    rm -rf /var/lib/apt/lists/*

# Configurer Apache pour permettre les .htaccess et activer mod_rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# Copier uniquement les fichiers PHP et frontend
COPY ./src /var/www/html
# Copier le frontend aussi
COPY ./src/frontend /var/www/html/frontend

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
