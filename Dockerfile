# Utiliser l'image PHP avec Apache
FROM php:8.2-apache

# Mettre à jour les paquets et installer les extensions nécessaires
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y --no-install-recommends curl && \
    docker-php-ext-install mysqli pdo_mysql && \
    a2enmod rewrite && \
    rm -rf /var/lib/apt/lists/*

# Configurer Apache pour permettre les .htaccess et activer mod_rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf && \
    a2enmod rewrite


# Installer Node.js et npm (si non déjà installé)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail pour l'application
WORKDIR /var/www/html

# Copier les fichiers du projet dans le conteneur
COPY . .

# Installer les dépendances Node.js (GSAP)
RUN npm install gsap

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
