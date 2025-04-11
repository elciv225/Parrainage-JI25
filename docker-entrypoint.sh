#!/bin/bash
set -e

# Fix ServerName
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Activer les modules nécessaires
a2enmod rewrite ssl headers

# VHost HTTP → redirige vers HTTPS (configuration simplifiée)
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    ServerAdmin admin@ji-miage.com
    DocumentRoot /var/www/html

    # Redirection simple vers HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Configuration HTTPS statique plutôt que de laisser Certbot la générer
cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
    <VirtualHost *:443>
        ServerName ji-miage.com
        ServerAdmin admin@ji-miage.com
        DocumentRoot /var/www/html

        ErrorLog \${APACHE_LOG_DIR}/error.log
        CustomLog \${APACHE_LOG_DIR}/access.log combined

        SSLEngine on
        SSLCertificateFile /etc/letsencrypt/live/ji-miage.com/fullchain.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/ji-miage.com/privkey.pem

        <FilesMatch "\.(cgi|shtml|phtml|php)$">
            SSLOptions +StdEnvVars
        </FilesMatch>

        <Directory /var/www/html>
            Options FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
</IfModule>
EOF

# Activer le site SSL
a2ensite default-ssl

# Démarrer Apache temporairement pour Certbot
apache2ctl start

# Générer le certificat si non existant
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com \
    --keep-until-expiring \
    --redirect
else
  echo "✅ Certificat SSL déjà présent"
fi

# Supprimer les configurations générées par Certbot pour éviter les doublons
# et garder uniquement nos configurations personnalisées
rm -f /etc/apache2/sites-enabled/000-default-le-ssl.conf

# Stop temporaire Apache
apache2ctl stop

# Cron pour renouvellement automatique
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Redémarrer Apache en foreground
exec apache2-foreground