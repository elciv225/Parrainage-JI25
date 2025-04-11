#!/bin/bash

# Vérifier si certificat déjà existant
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
    echo "🔐 Génération du certificat SSL Let's Encrypt..."

    # Lancer Apache en tâche de fond pour que Certbot puisse utiliser le challenge
    apache2ctl start

    # Lancer certbot
    certbot --apache --non-interactive --agree-tos \
      --email admin@ji-miage.com \
      -d ji-miage.com -d www.ji-miage.com

    # Stop Apache pour le relancer proprement en foreground
    apache2ctl stop
else
    echo "✅ Certificat SSL déjà présent"
fi

# Configurer renouvellement auto
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Lancer Apache en avant-plan
exec apache2-foreground
