FROM php:8.2-apache

WORKDIR /var/www/html

# Installer dépendances PHP, Apache et acme.sh
RUN apt-get update && apt-get install -y \
    curl git socat cron sudo unzip zip \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev \
  && docker-php-ext-install mysqli pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer acme.sh avec ton email perso
RUN git clone https://github.com/acmesh-official/acme.sh /opt/acme.sh \
  && /opt/acme.sh/acme.sh --install --home /opt/acme.sh \
  --accountemail elielassy06@gmail.com

# Activer .htaccess dans Apache
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier les fichiers du site
COPY ./src /var/www/html

# Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
