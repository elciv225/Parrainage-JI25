#!/bin/bash
set -e

# Fixe le nom du serveur Apache pour éviter les warnings
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules nécessaires
a2enmod rewrite ssl headers

# === Configuration HTTP (port 80) avec redirection vers HTTPS ===
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    Redirect permanent / https://ji-miage.com/

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# === Configuration HTTPS (port 443) avec certificat déjà généré ===
cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
    <VirtualHost *:443>
        ServerName ji-miage.com
        DocumentRoot /var/www/html

        <Directory /var/www/html>
            Options FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        SSLEngine on
        SSLCertificateFile /etc/letsencrypt/live/ji-miage.com/fullchain.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/ji-miage.com/privkey.pem

        ErrorLog \${APACHE_LOG_DIR}/error.log
        CustomLog \${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
</IfModule>
EOF

# Activer le site SSL
a2ensite default-ssl

# (Facultatif) activer les tâches cron si renouvellement sera utilisé plus tard
service cron start

# Démarrer Apache en mode foreground
exec apache2-foreground
