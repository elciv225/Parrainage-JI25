#!/bin/bash
set -e

echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf
a2enmod rewrite ssl headers

# Redirection HTTP vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Chemins vers certificats (non renommés)
CERT_PATH="/etc/ssl/custom"
CERT_CRT="$CERT_PATH/certificate.crt"
CERT_KEY="$CERT_PATH/private.key"
CERT_CHAIN="$CERT_PATH/ca_bundle.crt"

# Vérifications de présence + non-vide
for file in "$CERT_CRT" "$CERT_KEY" "$CERT_CHAIN"; do
  if [ ! -s "$file" ]; then
    echo "❌ Le fichier $file est manquant ou vide."
    exit 1
  fi
done

# Configuration SSL Apache
cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName ji-miage.com
    DocumentRoot /var/www/html

    SSLEngine on
    SSLCertificateFile $CERT_CRT
    SSLCertificateKeyFile $CERT_KEY
    SSLCertificateChainFile $CERT_CHAIN

    <Directory /var/www/html>
        Options FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
</IfModule>
EOF

a2ensite default-ssl
service cron start
exec apache2-foreground
