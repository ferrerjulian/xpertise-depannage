# Xpertise Dépannage — Site web

Site statique pour **xpertise-dépannage.fr** : entreprise locale de dépannage plomberie et électricité à Lyon et dans la métropole lyonnaise.

## Stack

- HTML5 / CSS3 / JavaScript natif
- Aucune dépendance, aucun build : 100 % statique
- Police Inter via Google Fonts
- Données structurées Schema.org (LocalBusiness, Plumber, Electrician, FAQPage, Service, BreadcrumbList)
- Responsive mobile first, sticky CTA mobile, menu burger
- Sitemap.xml + robots.txt

## Structure

```
xpertise-depannage/
├── index.html                         # Page d'accueil
├── a-propos.html                      # À propos
├── contact.html                       # Page contact + formulaire
├── mentions-legales.html
├── politique-confidentialite.html
├── sitemap.xml
├── robots.txt
├── assets/
│   ├── css/style.css                  # Charte graphique complète
│   ├── js/main.js                     # Menu mobile + interactions
│   └── img/                           # (à compléter avec photos / logo)
├── services/                          # 9 pages services SEO
│   ├── depannage-plomberie-lyon.html
│   ├── urgence-plomberie-lyon.html
│   ├── reparation-fuite-eau-lyon.html
│   ├── remplacement-chauffe-eau-lyon.html
│   ├── depannage-electricite-lyon.html
│   ├── urgence-electricite-lyon.html
│   ├── recherche-panne-electrique-lyon.html
│   ├── remplacement-tableau-electrique-lyon.html
│   └── mise-en-securite-electrique-lyon.html
└── local/                             # 5 pages locales SEO
    ├── depannage-lyon.html
    ├── depannage-villeurbanne.html
    ├── depannage-tassin-la-demi-lune.html
    ├── depannage-caluire-et-cuire.html
    └── depannage-metropole-lyon.html
```

## Charte graphique

- **Bleu nuit primaire** : `#1a2332` — sérieux, professionnel, cohérent avec l'univers Xpertise Rénovation.
- **Orange accent dépannage** : `#d8651f` — chaleur, urgence, action.
- **Typographie** : Inter (400/500/600/700/800).
- **Boutons** : orange chaleureux pour les CTA principaux (appel/devis), outline pour les actions secondaires.

## SEO local

- 1 page d'accueil orientée conversion
- 9 pages services ciblant les requêtes principales (dépannage plomberie Lyon, urgence électricité Lyon, etc.)
- 5 pages locales (Lyon, Villeurbanne, Tassin, Caluire, métropole) — contenu original par ville pour éviter la duplication
- Schema.org sur toutes les pages (LocalBusiness, Plumber, Electrician, FAQPage, Service, BreadcrumbList)
- Maillage interne dense via sidebar et CTA contextuels
- Sitemap.xml généré automatiquement

## Modifier le contenu

Les pages services et locales sont générées par un script Python (`build_pages.py` à la racine du repo de travail). Pour ajouter une page locale ou un service :

1. Éditer `build_pages.py` (listes `PAGES_SERVICES` ou `PAGES_LOCAL`)
2. Lancer `python3 build_pages.py`
3. Pousser sur GitHub et redéployer

Pour modifier directement une page existante, éditer le fichier `.html` correspondant suffit.

## Déploiement

Voir [DEPLOIEMENT.md](DEPLOIEMENT.md) pour la procédure complète GitHub + Hostinger.

## Numéros et contacts utilisés

- Téléphone : 06 17 03 11 72
- Email : contact@xpertise-depannage.fr
- À adapter dans : `index.html`, `assets/css/style.css` (rien à changer), et tous les fichiers générés (mettre à jour `build_pages.py` puis régénérer).

## Checklist avant mise en production

- [ ] Vérifier le numéro de téléphone et l'email partout
- [ ] Compléter les mentions légales (raison sociale, SIRET, RCS, capital)
- [ ] Ajouter le logo Xpertise dans `assets/img/`
- [ ] Ajouter quelques photos de chantier (libres de droits ou propres) dans `assets/img/`
- [ ] Créer une image OG (`og-image.jpg`, 1200×630 px) pour le partage social
- [ ] Vérifier les avis clients (à remplacer par de vrais avis recueillis)
- [ ] Configurer le DNS du domaine xpertise-dépannage.fr vers Hostinger
- [ ] Soumettre le sitemap dans Google Search Console
- [ ] Créer / lier la fiche Google Business Profile
