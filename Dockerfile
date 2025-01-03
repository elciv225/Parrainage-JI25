# Ce fichier permet de configuer plusieurs chose
FROM php:8.2-apache

# Mettre à jour la bibliothèque d'extension
RUN apt-get update && apt-get upgrade -y

# Pour installer des extensions && Pour activer les extension
RUN docker-php-ext-install mysqli pdo && docker-php-ext-enable mysqli pdo pdo_mysql

EXPOSE 80