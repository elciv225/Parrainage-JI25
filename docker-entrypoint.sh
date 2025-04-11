#!/bin/bash
set -e

# Fix Apache ServerName to avoid warnings
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Activer les modules nécessaires
a2enmod rewrite ssl headers

# Configuration HTTP (port 80)
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    ServerAdmin admin@ji-miage.com
    DocumentRoot /var/www/html

    # Pour que Certbot puisse accéder au challenge
    Alias /.well-known/acme-challenge/ /var/www/html/.well-known/acme-challenge/

    <Directory /var/www/html>
        Options FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <Directory "/var/www/html/.well-known/acme-challenge/">
        AllowOverride None
        Options None
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Supprimer toute ancienne conf SSL
rm -f /etc/apache2/sites-enabled/default-ssl.conf

# Démarrer Apache temporairement pour le challenge
apache2ctl start

# Générer le certificat via webroot si manquant
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL via webroot..."
  mkdir -p /var/www/html/.well-known/acme-challenge
  certbot certonly --webroot \
    --webroot-path /var/www/html \
    --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Stop temporaire Apache
apache2ctl stop

# Configuration HTTPS (port 443)
cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
    <VirtualHost *:443>
        ServerName ji-miage.com
        ServerAdmin admin@ji-miage.com
        DocumentRoot /var/www/html

        <Directory /var/www/html>
            Options FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog \${APACHE_LOG_DIR}/error.log
        CustomLog \${APACHE_LOG_DIR}/access.log combined

        SSLEngine on
        SSLCertificateFile /etc/letsencrypt/live/ji-miage.com/fullchain.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/ji-miage.com/privkey.pem
    </VirtualHost>
</IfModule>
EOF

# Activer le site SSL
a2ensite default-ssl

# Rediriger HTTP vers HTTPS (après Certbot)
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Configurer le renouvellement automatique
echo "0 3 * * * certbot renew --quiet --webroot --webroot-path /var/www/html --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Démarrer Apache en mode foreground
exec apache2-foreground
