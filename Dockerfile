# Ce fichier permet de configuer plusieurs chose
FROM php:8.2-apache

# Mettre à jour la bibliothèque d'extension
RUN apt-get update && apt-get upgrade -y

# Installer et activer les extensions nécessaires
RUN docker-php-ext-install mysqli pdo_mysql

# Activer le module rewrite d'Apache
RUN a2enmod rewrite

# Configurer Apache pour permettre les .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80