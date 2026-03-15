# 📦 Installation de la Base de Données pour les Convois

Ce système permet de stocker les convois et leurs photos dans une base de données MySQL au lieu du localStorage, ce qui résout définitivement les problèmes de quota.

## 🚀 Installation

### 1. Configuration de la Base de Données

1. **Ouvrez phpMyAdmin** (http://localhost/phpmyadmin)

2. **Créez la base de données** (ou laissez le script la créer automatiquement) :
   - Nom : `transcs`
   - Interclassement : `utf8mb4_unicode_ci`

3. **Vérifiez/modifiez la configuration** dans `config.php` :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'transcs');
   define('DB_USER', 'root');  // Par défaut dans WAMP
   define('DB_PASS', '');      // Par défaut vide dans WAMP
   ```

### 2. Import du Fichier SQL

**⚠️ IMPORTANT : Vérifiez d'abord votre utilisateur MySQL dans `config.php`**

**Option A - Si vous utilisez l'utilisateur 'transcs' ou un autre utilisateur :**
1. Ouvrez phpMyAdmin (http://localhost/phpmyadmin)
2. **Connectez-vous avec l'utilisateur root** (ou un admin) pour créer la base
3. Cliquez sur l'onglet **"SQL"** en haut
4. Copiez-collez le contenu de `database.sql` dans la zone SQL
5. Cliquez sur **"Exécuter"**
6. ✅ La base de données, les tables et les permissions seront créées

**Option B - Si la base existe déjà :**
1. Ouvrez phpMyAdmin
2. Sélectionnez la base **"transport_"** dans le menu de gauche
3. Cliquez sur l'onglet **"SQL"**
4. Copiez-collez le contenu de `database-simple.sql` (sans la création de base)
5. Cliquez sur **"Exécuter"**

**Option C - Initialisation Automatique :**
La base de données et les tables seront créées automatiquement lors de la première utilisation via le script `initDatabase()` dans `config.php` (si l'utilisateur a les droits).

### 3. Structure de la Base de Données

**Table `convois`** :
- `id` : ID unique du convoi
- `pseudo` : Pseudo du proposant
- `discord` : Discord du proposant
- `tmp_link`, `truckbook_link`, `trucky_link` : Liens vers les plateformes
- `date`, `heure` : Date et heure du convoi
- `parcours` : Itinéraire
- `description` : Description du convoi
- `rules` : Règlement spécifique
- `date_creation` : Date de création

**Table `photos`** :
- `id` : ID unique de la photo
- `convoi_id` : ID du convoi (clé étrangère)
- `photo_data` : Données binaires de la photo (LONGBLOB)
- `photo_type` : Type de l'image (jpg, png, webp)
- `date_upload` : Date d'upload

## 📡 API Disponibles

### `api/api-save-convoi.php`
Sauvegarde un convoi dans la base de données.
- **Méthode** : POST
- **Body** : JSON avec les données du convoi
- **URL** : `api/api-save-convoi.php`

### `api/api-upload-photos.php`
Sauvegarde les photos d'un convoi.
- **Méthode** : POST
- **Body** : JSON avec `convoi_id` et `photos` (tableau Base64)
- **URL** : `api/api-upload-photos.php`

### `api/api-get-convois.php`
Récupère tous les convois.
- **Méthode** : GET
- **Retour** : JSON avec la liste des convois
- **URL** : `api/api-get-convois.php`

### `api/api-get-photos.php`
Récupère les photos d'un convoi.
- **Méthode** : GET
- **Paramètre** : `convoi_id`
- **Retour** : JSON avec les photos en Base64
- **URL** : `api/api-get-photos.php?convoi_id=X`

### `api/api-delete-convoi.php`
Supprime un convoi (et ses photos en cascade).
- **Méthode** : POST ou DELETE
- **Body** : JSON avec `convoi_id`
- **URL** : `api/api-delete-convoi.php`

### `api/api-cleanup-convois.php`
Nettoie automatiquement les convois expirés (30 min après date/heure).
- **Méthode** : GET
- **Retour** : JSON avec le nombre de convois supprimés
- **URL** : `api/api-cleanup-convois.php`

## ✅ Avantages

- ✅ **Pas de limite de quota** : Les photos sont stockées en base de données
- ✅ **Persistance** : Les données ne sont pas perdues à la fermeture du navigateur
- ✅ **Performance** : Chargement optimisé des photos
- ✅ **Sécurité** : Les photos sont stockées côté serveur
- ✅ **Scalabilité** : Peut gérer des milliers de convois

## 🔧 Migration depuis localStorage

Les anciens convois dans localStorage continueront de fonctionner, mais les nouveaux seront sauvegardés en base de données. Vous pouvez migrer les anciens convois si nécessaire.

## ⚠️ Notes Importantes

- Assurez-vous que PHP a les extensions `pdo` et `pdo_mysql` activées
- Vérifiez les permissions d'écriture pour MySQL
- Les photos sont limitées à 5MB chacune
- La suppression d'un convoi supprime automatiquement ses photos (CASCADE)
