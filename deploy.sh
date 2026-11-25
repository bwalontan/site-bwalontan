#!/bin/sh
# Mise en ligne Bwa Lontan — exécuté sur le serveur o2switch par une tâche planifiée cPanel.
# Récupère la dernière version de la branche main depuis GitHub et la copie dans le dossier du site.
# Usage : sh deploy.sh [dossier_cible]   (par défaut : le sous-domaine de test nouveau.bwalontan.re)
set -e
DEPOT="$HOME/repositories/site-bwalontan"
CIBLE="${1:-$HOME/nouveau.bwalontan.re}"

cd "$DEPOT"
git fetch -q origin main
git reset -q --hard origin/main

rsync -a --delete \
  --exclude '.git/' --exclude '.github/' --exclude 'README.md' --exclude 'deploy.sh' \
  --exclude '.well-known/' --exclude 'cgi-bin/' --exclude '.user.ini' --exclude 'error_log' \
  "$DEPOT/" "$CIBLE/"
