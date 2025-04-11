FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    apache2 cron sudo curl git zip unzip snapd \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev \
  && docker-php-ext-install mysqli pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Fix snap in Docker
RUN systemctl unmask snapd && \
    systemctl enable snapd && \
    ln -s /var/lib/snapd/snap /snap || true

# Installer certbot depuis Snap (officiel)
RUN snap install core && snap refresh core && \
    snap install --classic certbot && \
    ln -s /snap/bin/certbot /usr/bin/certbot

# Activer .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY ./src /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
