#!/bin/bash
set -e

# Fixe le nom de domaine global pour Apache
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules nécessaires
a2enmod rewrite ssl headers

# VirtualHost HTTP → redirige vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    ServerAlias www.ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Supprime le fichier SSL par défaut si présent
rm -f /etc/apache2/sites-enabled/default-ssl.conf

# Démarre Apache temporairement (pour que Certbot accède au challenge)
apache2ctl start

# Génère certificat si non existant
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com -d www.ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Corrige le fichier SSL généré par Certbot s’il y a redirections multiples
SSL_CONF="/etc/apache2/sites-available/000-default-le-ssl.conf"
if [ -f "$SSL_CONF" ]; then
  sed -i '/RewriteEngine On/d' "$SSL_CONF"
  sed -i '/RewriteCond %{HTTPS} off/d' "$SSL_CONF"
  sed -i '/RewriteRule ^ https:/d' "$SSL_CONF"
fi

# Stop Apache temporaire
apache2ctl stop

# Ajoute cron pour renouvellement auto
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Redémarre Apache en foreground
exec apache2-foreground
