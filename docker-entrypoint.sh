#!/bin/bash
set -e

# Fix le nom de domaine pour Apache (évite warning ServerName)
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules Apache nécessaires
a2enmod rewrite ssl headers

# Création du virtualhost HTTP avec redirection vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOVHOST
<VirtualHost *:80>
    ServerName ji-miage.com
    ServerAlias www.ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOVHOST

# Supprimer SSL par défaut
rm -f /etc/apache2/sites-enabled/default-ssl.conf

# Démarre Apache temporairement pour le challenge Certbot
apache2ctl start

# Génère le certificat s’il n’existe pas déjà
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com -d www.ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Arrête Apache (on le redémarrera en foreground)
apache2ctl stop

# Planifie le renouvellement automatique
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Démarre Apache en mode "foreground" (le vrai lancement)
exec apache2-foreground
