# Structure du Projet 

## 📁 Organisation des fichiers

```
/
├── api/                          # API PHP pour les convois
│   ├── api-cleanup-convois.php   # Nettoyage automatique des convois expirés
│   ├── api-delete-convoi.php     # Suppression d'un convoi (admin)
│   ├── api-get-convois.php       # Récupération de tous les convois
│   ├── api-get-photos.php        # Récupération des photos d'un convoi
│   ├── api-save-convoi.php       # Sauvegarde d'un nouveau convoi
│   ├── api-upload-photos.php     # Upload des photos d'un convoi
│   └── webhook-proxy.php         # Proxy pour les webhooks Discord
│
├── assets/                       # Ressources statiques
│   ├── css/
│   │   └── style.css             # Feuille de style principale
│   └── js/
│       └── script.js             # Script JavaScript principal
│
├── cron/                         # Scripts de maintenance
│   └── cron-cleanup.php          # Script de nettoyage automatique (cron job)
│
├── docs/                         # Documentation
│   ├── README-DATABASE.md        # Documentation de la base de données
│   ├── SOLUTION-ERREUR-1044.md   # Solution pour l'erreur MySQL 1044
│   └── STRUCTURE-PROJET.md       # Ce fichier
│
├── img/                          # Images du site
│   └── [images...]
│
├── BOT/                          # Bot Discord (projet séparé)
│   └── [fichiers du bot...]
│
├── config.php                    # Configuration de la base de données
├── index.html                    # Page d'accueil
├── convois.html                  # Liste des convois
├── proposition-convoi.html       # Formulaire de proposition de convoi
├── contact.html                  # Page de contact
├── entreprise.html               # Page entreprise
├── flotte.html                   # Page flotte
├── partenaires.html              # Page partenaires
├── pourquoinouschoisir.html      # Page "Pourquoi nous choisir"
├── reglement.html                # Page règlement
├── formulaire-partenaire.html    # Formulaire partenaire
├── maintenance.html              # Page de maintenance
└── logo.png                      # Logo du site
```

## 🔗 Chemins relatifs

### Dans les fichiers HTML
- **CSS** : `assets/css/style.css`
- **JavaScript** : `assets/js/script.js`
- **API** : `api/api-*.php`

### Dans les fichiers PHP (api/)
- **Config** : `__DIR__ . '/../config.php'`

### Dans les fichiers PHP (cron/)
- **Config** : `__DIR__ . '/../config.php'`

## 📝 Notes importantes

1. **config.php** reste à la racine car il est utilisé par tous les fichiers PHP
2. Tous les fichiers API sont dans `api/` pour une meilleure organisation
3. Les assets (CSS/JS) sont dans `assets/` pour une meilleure structure
4. La documentation est centralisée dans `docs/`
5. Les scripts de maintenance sont dans `cron/`

## 🔄 Migration effectuée

Tous les chemins ont été mis à jour automatiquement lors de la réorganisation :
- ✅ Références CSS mises à jour dans tous les fichiers HTML
- ✅ Références JavaScript mises à jour dans tous les fichiers HTML
- ✅ Références API mises à jour dans tous les fichiers HTML
- ✅ Références config.php mises à jour dans tous les fichiers PHP
- ✅ Chemin du cron job mis à jour dans la documentation

## 🚀 Utilisation

Le site fonctionne exactement comme avant, mais avec une structure plus organisée et maintenable.
