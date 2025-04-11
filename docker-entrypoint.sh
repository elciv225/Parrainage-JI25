#!/bin/bash

# Fix DNS Apache (évite les warnings)
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules Apache nécessaires
a2enmod ssl rewrite headers

# Supprimer les anciens VirtualHosts SSL par défaut s’ils existent
rm -f /etc/apache2/sites-enabled/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Redirection HTTP -> HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
  ServerName ji-miage.com
  ServerAlias www.ji-miage.com
  Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Lancer temporairement Apache pour le challenge Certbot
apache2ctl start

# Si certificat absent, on le crée
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL pour ji-miage.com + www..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com -d www.ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Planifie renouvellement auto via cron
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Relance Apache en foreground
exec apache2-foreground
