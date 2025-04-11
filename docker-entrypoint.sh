#!/bin/bash
set -e

# Fixe le ServerName pour Apache (évite les warnings)
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules Apache nécessaires
a2enmod rewrite ssl headers

# Création du VirtualHost HTTP avec redirection vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOVHOST
<VirtualHost *:80>
    ServerName ji-miage.com
    ServerAlias www.ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOVHOST

# Supprimer SSL par défaut
rm -f /etc/apache2/sites-enabled/default-ssl.conf

# Démarrer Apache temporairement pour le challenge Certbot
apache2ctl start

# Générer le certificat s’il n’existe pas déjà
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com -d www.ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# 🔁 Supprimer toute redirection dans le vhost SSL s’il y en a
SSL_CONF="/etc/apache2/sites-available/000-default-le-ssl.conf"
if [ -f "$SSL_CONF" ]; then
  sed -i '/RewriteEngine On/d' "$SSL_CONF"
  sed -i '/RewriteCond %{HTTPS} off/d' "$SSL_CONF"
  sed -i '/RewriteRule ^ https:/d' "$SSL_CONF"
fi

# Arrêter Apache pour le relancer proprement
apache2ctl stop

# Planifie le renouvellement automatique du certificat
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Redémarrer Apache en foreground
exec apache2-foreground
