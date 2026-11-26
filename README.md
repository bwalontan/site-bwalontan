# Site internet Bwa Lontan

Site statique (HTML/CSS, sans outil de construction) de www.bwalontan.re.

- `index.html` : page d'accueil
- `assets/css/style.css` : charte (couleurs et polices de la charte graphique 2023)
- `assets/img/` : photos (Ouranos) redimensionnées et logos
- `assets/fonts/` : Cormorant Upright et Montserrat, hébergées localement (pas d'appel à Google Fonts)

Statut : maquette de la page d'accueil, en cours de validation.

## Mise en ligne (o2switch)

- `contact.php` : traitement du formulaire (PHP `mail()`), envoi vers contact@bwalontan.re. Fonctionne uniquement sur un hébergement PHP. Les e-mails du domaine sont hébergés hors o2switch : si les messages arrivent en spam, ajouter o2switch à l'enregistrement SPF.
- `.htaccess` : HTTPS + www, redirection des anciennes adresses WordPress, page 404, cache.
- `sitemap.xml` et `robots.txt` à déclarer dans Google Search Console.

## Mise en ligne automatique

C'est le serveur o2switch qui va chercher le site sur GitHub (dépôt public, aucun mot de passe stocké chez GitHub).

- cPanel › Git Version Control : clone de ce dépôt dans `~/repositories/site-bwalontan`.
- cPanel › Tâches Cron : toutes les 15 minutes, `deploy.sh ~/www.bwalontan.re` (site en ligne) puis `deploy.sh ~/nouveau.bwalontan.re` (site de test, non indexé).
- Le domaine bwalontan.re pointe vers `~/www.bwalontan.re` (cPanel › Domaines). L'ancien WordPress est conservé intact dans `~/public_html` : pour revenir en arrière, remettre `public_html` comme racine du domaine.
- `deploy.sh` récupère `main` puis copie les fichiers dans le dossier du site (par défaut `~/nouveau.bwalontan.re`, sous-domaine de test).
- Délai entre une modification sur `main` et sa mise en ligne : 15 minutes au maximum.
