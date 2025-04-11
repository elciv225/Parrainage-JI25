#!/bin/bash
set -e

echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf
a2enmod rewrite ssl headers

# Config HTTP
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Vérifie que les fichiers certif existent
CERT_PATH=/etc/ssl/custom
if [ ! -f "$CERT_PATH/ji-miage.com.crt" ] || [ ! -f "$CERT_PATH/ji-miage.com.key" ]; then
  echo "❌ Certificats SSL ZeroSSL non trouvés dans $CERT_PATH"
  exit 1
fi

# Config SSL Apache
cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName ji-miage.com
    DocumentRoot /var/www/html

    SSLEngine on
    SSLCertificateFile $CERT_PATH/ji-miage.com.crt
    SSLCertificateKeyFile $CERT_PATH/ji-miage.com.key
    SSLCertificateChainFile $CERT_PATH/ca_bundle.crt

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
