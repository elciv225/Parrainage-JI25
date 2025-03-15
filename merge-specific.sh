#!/bin/bash
# Récupère les fichiers spécifiques depuis votre branche de développement et les applique sur main

# Vérifie les arguments
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 nom_de_votre_branche"
    exit 1
fi

BRANCH=$1

# Sauvegarde la branche actuelle
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)

# Checkout main
git checkout main

# Checkout les dossiers et fichiers spécifiques depuis la branche de développement
git checkout $BRANCH -- src/frontend
git checkout $BRANCH -- src/backend/client/controllers
git checkout $BRANCH -- src/backend/client/models
git checkout $BRANCH -- src/backend/client/routes
git checkout $BRANCH -- src/backend/client/views
git checkout $BRANCH -- src/index.php

# Commit les changements
git commit -m "Merge sélectif des dossiers et fichiers spécifiques depuis $BRANCH"

# Retourne à la branche originale (optionnel)
git checkout $CURRENT_BRANCH

echo "Merge sélectif terminé avec succès!"