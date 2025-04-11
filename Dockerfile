FROM php:8.2-apache

WORKDIR /var/www/html

# Installer les dépendances système + venv Python + certbot via pip dans un venv
RUN apt-get update && apt-get install -y \
    apache2 cron sudo curl git zip unzip \
    python3 python3-venv python3-pip \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev \
  && python3 -m venv /opt/certbot-venv \
  && /opt/certbot-venv/bin/pip install --upgrade pip \
  && /opt/certbot-venv/bin/pip install certbot \
  && ln -s /opt/certbot-venv/bin/certbot /usr/bin/certbot \
  && docker-php-ext-install mysqli pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY ./src /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
