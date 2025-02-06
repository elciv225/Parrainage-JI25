# Utiliser l'image PHP avec Apache
FROM php:8.2-apache

# Mettre à jour la bibliothèque d'extension
RUN apt-get update && apt-get upgrade -y

# Installer et activer les extensions nécessaires
RUN docker-php-ext-install mysqli pdo_mysql

# Activer le module rewrite d'Apache
RUN a2enmod rewrite

# Configurer Apache pour permettre les .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Vérifier si Node.js est déjà installé, sinon l'installer
RUN if ! command -v node > /dev/null; then \
      apt-get install -y curl && \
      curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
      apt-get install -y nodejs; \
    fi

# Définir le répertoire de travail pour l'installation de GSAP
WORKDIR /var/www/html/src

# Vérifier si GSAP est déjà installé, sinon l'installer
RUN if [ ! -d "node_modules/gsap" ]; then npm install gsap; fi

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
