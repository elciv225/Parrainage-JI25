#!/bin/bash
set -e

# Fixe le ServerName pour éviter les warnings
echo "ServerName ji-miage.com" >> /etc/apache2/apache2.conf

# Active les modules Apache nécessaires
a2enmod rewrite ssl headers

# Crée le VirtualHost HTTP avec redirection vers HTTPS
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    ServerName ji-miage.com
    ServerAlias www.ji-miage.com
    Redirect permanent / https://ji-miage.com/
</VirtualHost>
EOF

# Supprimer les anciens SSL par défaut
rm -f /etc/apache2/sites-enabled/default-ssl.conf

# Démarrer Apache temporairement pour Certbot
apache2ctl start

# Génère le certificat SSL si nécessaire
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com -d www.ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Ajoute une redirection forcée dans le SSL si manquante
SSL_CONF="/etc/apache2/sites-available/ji-miage.com-le-ssl.conf"
if [ -f "$SSL_CONF" ] && ! grep -q "RewriteEngine On" "$SSL_CONF"; then
  sed -i '/<\/VirtualHost>/i RewriteEngine On\nRewriteCond %{HTTPS} off\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]' "$SSL_CONF"
fi

# Cron pour renouveler le certificat
echo "0 3 * * * certbot renew --quiet --post-hook 'service apache2 reload'" > /etc/cron.d/certbot-renew
chmod 0644 /etc/cron.d/certbot-renew
crontab /etc/cron.d/certbot-renew
service cron start

# Redémarre Apache proprement au premier plan
exec apache2-foreground
