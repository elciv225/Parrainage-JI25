#!/bin/bash
set -e

# Fix ServerName
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Activer les modules nécessaires
a2enmod rewrite ssl headers

# VHost HTTP → redirige vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Supprimer vhost SSL par défaut
rm -f /etc/apache2/sites-enabled/default-ssl.conf

# Démarrer Apache temporairement pour Certbot
apache2ctl start

# Générer le certificat si non existant
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Nettoyage redirections dans le vhost SSL généré
SSL_CONF="/etc/apache2/sites-available/000-default-le-ssl.conf"
if [ -f "$SSL_CONF" ]; then
  sed -i '/RewriteEngine On/d' "$SSL_CONF"
  sed -i '/RewriteCond %{HTTPS} off/d' "$SSL_CONF"
  sed -i '/RewriteRule ^ https:/d' "$SSL_CONF"
fi

# Stop temporaire Apache
apache2ctl stop

# Cron pour renouvellement automatique
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Redémarrer Apache en foreground
exec apache2-foreground
