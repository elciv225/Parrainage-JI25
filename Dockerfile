# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Mettre à jour les paquets et installer les extensions nécessaires en une seule commande
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl unzip \
    && docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Configurer Apache pour activer mod_rewrite et permettre les .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier les fichiers de l'application en minimisant les changements de cache
COPY ./src /var/www/html

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
