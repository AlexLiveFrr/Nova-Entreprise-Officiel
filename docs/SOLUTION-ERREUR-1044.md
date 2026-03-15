# 🔧 Solution pour l'erreur #1044 - Accès refusé

## ❌ Erreur rencontrée :
```
#1044 - Accès refusé pour l'utilisateur: 'transcs'@'@%'. Base 'transcs'
```

## ✅ SOLUTION RAPIDE (Recommandée) :

### Utilisez le fichier `INSTALL-COMPLETE.sql`

1. **Ouvrez phpMyAdmin** : http://localhost/phpmyadmin
2. **⚠️ IMPORTANT : Connectez-vous avec ROOT** (pas avec transcs)
   - Si vous êtes connecté avec un autre utilisateur, déconnectez-vous
   - Reconnectez-vous avec `root` (mot de passe généralement vide)
3. **Cliquez sur l'onglet "SQL"** en haut
4. **Ouvrez le fichier `INSTALL-COMPLETE.sql`** dans un éditeur de texte
5. **Copiez TOUT le contenu** et **collez-le** dans la zone SQL de phpMyAdmin
6. **Cliquez sur "Exécuter"**
7. ✅ **C'est terminé !** La base, les tables et les permissions sont créées

---

## ✅ Solution étape par étape (Alternative) :

### Étape 1 : Créer la base de données avec ROOT

1. **Ouvrez phpMyAdmin** : http://localhost/phpmyadmin
2. **⚠️ IMPORTANT : Déconnectez-vous et reconnectez-vous avec ROOT**
   - Si vous êtes connecté avec `transcs`, déconnectez-vous
   - Reconnectez-vous avec l'utilisateur `root` (mot de passe généralement vide dans WAMP)
3. **Cliquez sur l'onglet "SQL"** en haut
4. **Copiez-collez ce code** :

```sql
-- Créer la base de données
CREATE DATABASE IF NOT EXISTS `transcs` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Donner les permissions à transcs
GRANT ALL PRIVILEGES ON `transcs`.* TO 'transcs'@'localhost';
FLUSH PRIVILEGES;
```

5. **Cliquez sur "Exécuter"**

### Étape 2 : Créer les tables

1. **Toujours connecté avec ROOT**, sélectionnez la base `transcs` dans le menu de gauche
2. **Cliquez sur l'onglet "SQL"**
3. **Copiez-collez le contenu de `database-simple.sql`** (sans la création de base)
4. **Cliquez sur "Exécuter"**

### Étape 3 : Vérifier la configuration

Vérifiez que `config.php` contient bien :
```php
define('DB_USER', 'transcs');
define('DB_PASS', '');  // Mettez le mot de passe si vous en avez un
```

## 🔍 Alternative : Utiliser ROOT directement

Si vous préférez utiliser ROOT au lieu de transcs :

1. **Modifiez `config.php`** :
```php
define('DB_USER', 'root');
define('DB_PASS', '');
```

2. **Exécutez `database.sql` avec ROOT** (il créera tout automatiquement)

## ✅ Vérification

Pour vérifier que tout fonctionne :

1. Dans phpMyAdmin, vous devriez voir la base `transcs`
2. Elle devrait contenir 2 tables : `convois` et `photos`
3. Testez en créant un nouveau convoi sur le site

## 🆘 Si ça ne fonctionne toujours pas

1. Vérifiez que MySQL est bien démarré dans WAMP
2. Vérifiez que l'utilisateur `transcs` existe dans MySQL
3. Essayez de vous connecter avec ROOT et exécutez :
```sql
SHOW GRANTS FOR 'transcs'@'localhost';
```
