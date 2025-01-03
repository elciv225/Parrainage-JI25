# Ce fichier permet de configuer plusieurs chose
FROM php:8.2-apache

# Mettre à jour la bibliothèque d'extension
RUN apt-get update && apt-get upgrade -y

# Installer et activer les extensions nécessaires
RUN docker-php-ext-install mysqli pdo_mysql

EXPOSE 80