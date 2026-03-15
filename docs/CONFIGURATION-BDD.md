# 🔧 Configuration de la Base de Données

## 📋 Deux modes disponibles

Le fichier `config.php` supporte deux modes de configuration :

### 1. 🏠 Mode LOCAL (WAMP - Développement)
Pour le développement en local avec WAMP.

### 2. 🌐 Mode DISTANT (Production)
Pour la production sur un serveur distant.

---

## 🚀 Configuration rapide

### Pour WAMP LOCAL (Recommandé pour le développement)

1. **Ouvrez `config.php`**
2. **Changez la ligne** :
   ```php
   $ENVIRONMENT = 'local';
   ```
3. **Vérifiez les paramètres** :
   ```php
   define('DB_HOST', 'localhost');  // ou '127.0.0.1'
   define('DB_NAME', 'transcsl');
   define('DB_USER', 'root');       // Utilisateur par défaut WAMP
   define('DB_PASS', '');           // Généralement vide dans WAMP
   ```

4. **Créez la base de données dans phpMyAdmin** :
   - Ouvrez http://localhost/phpmyadmin
   - Cliquez sur "Nouvelle base de données"
   - Nom : `transcsl`
   - Interclassement : `utf8mb4_unicode_ci`
   - Cliquez sur "Créer"

5. **Testez la connexion** :
   - Ouvrez `test-connection.php` dans votre navigateur
   - La base et les tables seront créées automatiquement si elles n'existent pas

### Pour SERVEUR DISTANT (Production)

1. **Ouvrez `config.php`**
2. **Changez la ligne** :
   ```php
   $ENVIRONMENT = 'distant';
   ```
3. **Vérifiez les paramètres** :
   ```php
   define('DB_HOST', 'transcsl.mysql.db');
   define('DB_NAME', 'transcsl');
   define('DB_USER', 'transcsl');
   define('DB_PASS', 'X1BN2Ygyub7JPgaDRdA6HBxXMrg');
   ```

4. **Vérifiez que le serveur est accessible** :
   - Le serveur doit être accessible depuis votre environnement
   - Vérifiez les règles de firewall
   - Vérifiez que le DNS résout correctement le nom d'hôte

---

## ⚠️ Erreur "Name or service not known"

Si vous voyez cette erreur :
```
php_network_getaddresses: getaddrinfo for transcsl.mysql.db failed: Name or service not known
```

**Cela signifie que :**
- Le serveur ne peut pas résoudre le nom d'hôte `transcsl.mysql.db`
- Vous êtes probablement en mode DISTANT mais le serveur n'est pas accessible

**Solutions :**
1. **Utilisez le mode LOCAL** si vous êtes en développement :
   ```php
   $ENVIRONMENT = 'local';
   ```

2. **Ou vérifiez la connectivité réseau** si vous devez utiliser le serveur distant :
   - Vérifiez votre connexion Internet
   - Vérifiez que le serveur MySQL distant est accessible
   - Contactez votre hébergeur si nécessaire

---

## ✅ Vérification

Après configuration, testez avec :
- `test-connection.php` : Teste la connexion et crée la base si nécessaire
- `test-api.html` : Teste l'API de récupération des convois

---

## 🔄 Basculer entre LOCAL et DISTANT

Pour basculer entre les deux modes, il suffit de changer :
```php
$ENVIRONMENT = 'local';   // Pour WAMP local
// ou
$ENVIRONMENT = 'distant';  // Pour serveur distant
```

Tous les autres paramètres seront automatiquement ajustés.
