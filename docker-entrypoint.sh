#!/bin/bash
set -e

echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf
a2enmod rewrite ssl headers

# === Config HTTP avec redirection HTTPS ===
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
  ServerName ji-miage.com
  Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Dossier SSL monté depuis le host
mkdir -p /etc/ssl/custom

# Démarrer Apache temporairement pour le challenge ACME
apache2ctl start

# === Générer certificat via acme.sh S'IL N'EXISTE PAS ===
if [ ! -f "/etc/ssl/custom/fullchain.pem" ] || [ ! -f "/etc/ssl/custom/ji-miage.com.key" ]; then
  echo "🔐 Certificat SSL manquant — génération avec acme.sh..."
  /opt/acme.sh/acme.sh --issue --webroot /var/www/html -d ji-miage.com

  echo "📦 Installation dans /etc/ssl/custom"
  /opt/acme.sh/acme.sh --install-cert -d ji-miage.com \
    --cert-file /etc/ssl/custom/ji-miage.com.crt \
    --key-file /etc/ssl/custom/ji-miage.com.key \
    --fullchain-file /etc/ssl/custom/fullchain.pem \
    --reloadcmd "apache2ctl graceful"
else
  echo "✅ Certificat déjà présent, pas de nouvelle demande."
fi

# Stop temporaire Apache
apache2ctl stop

# === Configuration HTTPS Apache ===
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
