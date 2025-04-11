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

mkdir -p /etc/ssl/custom
apache2ctl start

CERT_FULLCHAIN="/etc/ssl/custom/fullchain.pem"
CERT_KEY="/etc/ssl/custom/ji-miage.com.key"

# Si aucun certificat existant, on crée un auto-signé temporaire
if [ ! -f "$CERT_FULLCHAIN" ] || [ ! -f "$CERT_KEY" ]; then
  echo "⚠️ Aucune certification valide — création d’un certificat auto-signé..."
  openssl req -x509 -nodes -days 3 \
    -subj "/C=FR/ST=JI/L=MIAGE/O=JI/CN=ji-miage.com" \
    -newkey rsa:2048 \
    -keyout "$CERT_KEY" \
    -out "$CERT_FULLCHAIN"
fi

# Tentative silencieuse de Let's Encrypt si quota débloqué
if [ -f "$CERT_FULLCHAIN" ] && grep -q "BEGIN CERTIFICATE" "$CERT_FULLCHAIN"; then
  echo "🕒 Vérification du quota Let's Encrypt..."
  acme.sh --set-default-ca --server letsencrypt || true
  acme.sh --issue --webroot /var/www/html -d ji-miage.com || true
  acme.sh --install-cert -d ji-miage.com \
    --cert-file /etc/ssl/custom/ji-miage.com.crt \
    --key-file /etc/ssl/custom/ji-miage.com.key \
    --fullchain-file /etc/ssl/custom/fullchain.pem \
    --reloadcmd "apache2ctl graceful" || true
fi

apache2ctl stop

# Config SSL avec certificat (auto-signé ou réel)
cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
<VirtualHost *:443>
  ServerName ji-miage.com
  DocumentRoot /var/www/html

  SSLEngine on
  SSLCertificateFile /etc/ssl/custom/fullchain.pem
  SSLCertificateKeyFile /etc/ssl/custom/ji-miage.com.key

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
