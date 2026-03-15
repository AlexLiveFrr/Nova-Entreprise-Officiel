# Site Nova Entreprise Officiel

Site vitrine + espace d'administration pour une entreprise virtuelle de transport (OMSI 2), avec gestion des services/convois, profils chauffeurs, statistiques et formulaires.

## Fonctionnalités principales

- Pages publiques: accueil, entreprise, règlement, partenaires, recrutement.
- Espace admin: connexion, dashboard, accès rapide aux modules.
- Gestion des services/convois: création, mise à jour, suppression, participation.
- Système chauffeurs: classement, profils, statistiques, badges/rangs.
- Intégration Discord via proxy webhook pour certains formulaires/notifications.

## Stack technique

- Frontend: HTML, Tailwind CDN, CSS/JS custom.
- Backend: PHP (API REST simple).
- Base de données: MySQL/MariaDB (WAMP en local, OVH en production).

## Arborescence utile

- `index.html`: page d'accueil.
- `admin.html`, `login.html`: interface d'administration.
- `convois.html`, `proposition-convoi.html`, `statistiques.html`: modules de gestion.
- `api/`: endpoints PHP (convois, chauffeurs, auth, webhook, diagnostic).
- `assets/css/` et `assets/js/`: styles et scripts front.
- `docs/`: documentation complémentaire.

## Prérequis

- WAMP (Apache + PHP + MySQL/MariaDB).
- PHP avec extensions usuelles (`pdo_mysql`, `curl`, `json`).
- Navigateur moderne.

## Installation en local (WAMP)

1. Place le projet dans `c:\wamp64\www\SiteETS\LTDRS`.
2. Démarre Apache + MySQL depuis WAMP.
3. Ouvre `config.php` (racine) et passe:
   - `$ENVIRONMENT = 'local';`
4. Vérifie les identifiants DB locaux dans `config.php`:
   - `DB_HOST=localhost`, `DB_USER=root`, etc.
5. Lance une première page/API (ex: `index.html` ou `api/test-connection.php`) pour valider la connexion.

> La base peut être initialisée automatiquement par les fonctions d'initialisation selon les endpoints appelés.

## Déploiement (production)

- Repasse `$ENVIRONMENT` sur `distant` dans `config.php`.
- Configure des identifiants DB de production valides.
- Vérifie les droits d'accès PHP et les extensions.
- Teste les endpoints de diagnostic après mise en ligne.

## Sécurité (important)

Le projet contient actuellement des secrets/identifiants en dur dans certains fichiers.

À faire immédiatement avant mise en production:

1. Changer les identifiants admin dans `api/auth.php`.
2. Remplacer les mots de passe DB présents en clair dans `config.php` / `api/config.php`.
3. Déplacer les URLs webhooks Discord vers des variables d'environnement.
4. Restreindre CORS si possible (éviter `*` en production).
5. Ne jamais versionner de secrets réels dans Git.

## Endpoints API principaux

### Convois

- `api/api-get-convois.php`
- `api/api-save-convoi.php`
- `api/api-update-convoi.php`
- `api/api-delete-convoi.php`
- `api/api-participer.php`
- `api/api-get-photos.php`
- `api/api-upload-photos.php`

### Chauffeurs

- `api/chauffeurs-get.php`
- `api/chauffeurs-add.php`
- `api/chauffeurs-update-stats.php`
- `api/chauffeurs-delete.php`
- `api/chauffeurs-delete-all.php`

### Auth / Outils

- `api/auth.php`
- `api/api-admin-login.php`
- `api/test-connection.php`
- `api/debug-errors.php`
- `api/install-simple.php`
- `api/install-truckbook.php`
- `api/webhook-proxy.php`

## Documentation

- Voir l'index de documentation dans `docs/INDEX_DOCUMENTATION.md`.
- Résumé global: `docs/README_FINAL.md`.

## Auteur

Projet "Nova Entreprise Officiel" (LTDRS).
