# Démarrage temporaire pour Certbot
apache2ctl start

# SSL generation
if [ ! -f "/etc/letsencrypt/live/ji-miage.com/fullchain.pem" ]; then
  echo "🔐 Génération du certificat SSL..."
  certbot --apache --non-interactive --agree-tos \
    --email admin@ji-miage.com \
    -d ji-miage.com -d www.ji-miage.com
else
  echo "✅ Certificat SSL déjà présent"
fi

# Stop Apache cleanly to avoid port conflict
apache2ctl stop

# Démarre cron pour le renouvellement auto
service cron start

# Redémarre Apache en foreground (définitif)
exec apache2-foreground
