# Site internet Bwa Lontan

Site statique (HTML/CSS, sans outil de construction) de www.bwalontan.re.

- `index.html` : page d'accueil
- `assets/css/style.css` : charte (couleurs et polices de la charte graphique 2023)
- `assets/img/` : photos (Ouranos) redimensionnées et logos
- `assets/fonts/` : Cormorant Upright et Montserrat, hébergées localement (pas d'appel à Google Fonts)

Statut : maquette de la page d'accueil, en cours de validation.

## Mise en ligne (o2switch)

- `contact.php` : traitement du formulaire (PHP `mail()`), envoi vers contact@bwalontan.re. Fonctionne uniquement sur un hébergement PHP. L'adresse d'expédition `site@bwalontan.re` doit exister ou être autorisée sur le domaine.
- `.htaccess` : HTTPS + www, redirection des anciennes adresses WordPress, page 404, cache.
- `sitemap.xml` et `robots.txt` à déclarer dans Google Search Console.

## Mise en ligne automatique

`.github/workflows/deploy.yml` envoie le site par FTPS à chaque modification de `main`.
Secrets GitHub requis : `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD` (compte FTP o2switch limité au dossier du site).
