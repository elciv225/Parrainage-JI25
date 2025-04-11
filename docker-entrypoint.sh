#!/bin/bash
set -e

# Déclare le ServerName pour éviter les warnings Apache
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules nécessaires pour SSL et redirection
a2enmod rewrite ssl headers

# Configuration du VirtualHost HTTP avec redirection vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Définition des chemins des fichiers SSL tels qu'ils sont dans certs/
CERT_PATH="/etc/ssl/custom"
CERT_CRT="$CERT_PATH/certificate.crt"
CERT_KEY="$CERT_PATH/private.key"
CERT_CHAIN="$CERT_PATH/ca_bundle.crt"

# Vérification que tous les fichiers nécessaires sont présents et non vides
for file in "$CERT_CRT" "$CERT_KEY" "$CERT_CHAIN"; do
  if [ ! -s "$file" ]; then
    echo "❌ Le fichier $file est manquant ou vide."
    exit 1
  fi
done

# Configuration du VirtualHost HTTPS avec SSL ZeroSSL
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

# Active le site SSL
a2ensite default-ssl

# Lance cron (utile pour autre usage ou monitoring)
service cron start

echo "✅ Certificats détectés et configurés. Apache en HTTPS prêt."

# Démarre Apache en mode foreground (Docker compatible)
exec apache2-foreground
