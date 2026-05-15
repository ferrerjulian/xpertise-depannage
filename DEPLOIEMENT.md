# Déploiement — GitHub + Hostinger

Guide pas à pas pour publier le site sur **xpertise-dépannage.fr** via Hostinger, avec le code versionné sur GitHub.

---

## Étape 1 — Créer le repo GitHub

### Si vous n'avez pas encore Git installé

- **Windows** : télécharger Git depuis [git-scm.com](https://git-scm.com/download/win) et l'installer (options par défaut).
- Ouvrir **Git Bash** ou **PowerShell** dans le dossier du site.

### Initialiser et pousser le repo

```bash
cd "C:/Users/ferre/OneDrive/Documents/Claude/Projects/Création site internet/xpertise-depannage"

git init
git add .
git commit -m "Initial commit — site xpertise-depannage"
git branch -M main
```

### Créer le repo sur GitHub

1. Aller sur [github.com/new](https://github.com/new)
2. Nom du repo : `xpertise-depannage`
3. Visibilité : **Private** recommandée (Public si vous souhaitez le code visible).
4. **Ne pas** ajouter de README, .gitignore ou licence (déjà présents).
5. Cliquer sur **Create repository**.

GitHub vous affiche les commandes à exécuter. Reprenez celles-ci :

```bash
git remote add origin https://github.com/VOTRE-USERNAME/xpertise-depannage.git
git push -u origin main
```

À chaque modification ultérieure :

```bash
git add .
git commit -m "Description de la modification"
git push
```

---

## Étape 2 — Configurer le domaine sur Hostinger

### Si vous avez déjà acheté le domaine xpertise-dépannage.fr chez Hostinger

Le domaine est déjà connecté à votre hébergement. Passez directement à l'étape 3.

### Si le domaine est ailleurs

1. Connectez-vous à votre interface Hostinger → **Domaines**
2. Cliquez sur **Ajouter un domaine** ou **Connecter un domaine**
3. Entrez `xpertise-dépannage.fr`
4. Hostinger vous donnera des serveurs DNS à configurer chez votre registrar :
   - `ns1.dns-parking.com`
   - `ns2.dns-parking.com`
5. Modifier les serveurs DNS chez votre registrar (propagation : 1 à 24 h)

---

## Étape 3 — Téléverser les fichiers sur Hostinger

### Méthode A — File Manager Hostinger (la plus simple)

1. Hostinger → **Hébergement** → cliquez sur votre site
2. Onglet **Fichiers** → **Gestionnaire de fichiers**
3. Ouvrir le dossier `public_html`
4. **Supprimer** les fichiers par défaut (ex. `default.php`, `index.html` Hostinger)
5. Cliquer sur **Téléverser** (icône ⬆️ en haut à droite)
6. Sélectionner **tout le contenu** du dossier `xpertise-depannage` (sauf `README.md`, `DEPLOIEMENT.md`, `build_pages.py` et `.git`) :
   - `index.html`
   - `a-propos.html`, `contact.html`, `mentions-legales.html`, `politique-confidentialite.html`
   - `sitemap.xml`, `robots.txt`
   - dossiers `assets/`, `services/`, `local/`
7. Une fois l'upload terminé, vérifier que `index.html` est bien à la racine de `public_html`

### Méthode B — FTP (via FileZilla)

1. Hostinger → **Hébergement** → **Avancé** → **Comptes FTP**
2. Notez les identifiants FTP (hôte, utilisateur, mot de passe, port)
3. Téléchargez et installez [FileZilla](https://filezilla-project.org/)
4. Dans FileZilla, connexion rapide avec ces identifiants
5. Glisser-déposer le contenu de `xpertise-depannage/` (sans les fichiers de doc et `.git`) dans `/public_html/`

---

## Étape 4 — Activer HTTPS

1. Hostinger → **Hébergement** → onglet **Sécurité** → **SSL**
2. Cliquez sur **Installer** pour `xpertise-dépannage.fr`
3. Activez la **redirection HTTPS automatique**

Le certificat SSL gratuit (Let's Encrypt) se met en place en quelques minutes.

---

## Étape 5 — Vérifications post-déploiement

Une fois en ligne, vérifier :

- [ ] La page d'accueil charge correctement : https://xpertise-dépannage.fr
- [ ] Le menu navigue bien sur toutes les pages
- [ ] Le bouton téléphone sur mobile lance bien un appel
- [ ] Le formulaire de contact ouvre bien l'email (mailto:)
- [ ] Le sitemap est accessible : https://xpertise-dépannage.fr/sitemap.xml
- [ ] Le robots.txt est accessible : https://xpertise-dépannage.fr/robots.txt
- [ ] Tester l'affichage mobile (depuis un téléphone)
- [ ] Lancer un test [PageSpeed Insights](https://pagespeed.web.dev/) — viser >90 sur mobile

---

## Étape 6 — Référencement initial

### Google Search Console

1. Aller sur [search.google.com/search-console](https://search.google.com/search-console)
2. Ajouter la propriété `https://xpertise-dépannage.fr`
3. Valider la propriété (méthode : balise HTML ou DNS)
4. Soumettre le sitemap : `sitemap.xml`

### Google Business Profile

1. Créer / réclamer la fiche sur [business.google.com](https://business.google.com)
2. Catégorie principale : **Plombier** (ajouter **Électricien** en secondaire)
3. Zone d'intervention : Lyon + communes de la métropole
4. Lier le site : `https://xpertise-dépannage.fr`
5. Ajouter photos, horaires, services

### Annuaires locaux pertinents

- PagesJaunes (créer une fiche pro)
- Yelp, Trustpilot (selon stratégie)
- Annuaires d'artisans locaux

---

## Mise à jour ultérieure du site

À chaque modification :

```bash
git add .
git commit -m "Description"
git push
```

Puis re-téléverser les fichiers modifiés sur Hostinger via le File Manager ou FTP.

> 💡 **Astuce** : pour un déploiement automatique à chaque push GitHub, on peut configurer une GitHub Action FTP. Demandez si vous souhaitez cette automatisation.

---

## Besoin d'aide ?

Sur les premiers jours après mise en ligne, vérifier :
- L'indexation Google avec la requête `site:xpertise-dépannage.fr`
- Le bon fonctionnement des données structurées avec [Rich Results Test](https://search.google.com/test/rich-results)
- Les Core Web Vitals dans Search Console
