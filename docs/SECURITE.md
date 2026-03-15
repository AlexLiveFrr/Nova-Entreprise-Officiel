# 🔐 Sécurité - Administration 

## Identifiants par Défaut

⚠️ **IMPORTANT** : Changez immédiatement les identifiants par défaut !

**Identifiants actuels :**
- Identifiant : `admin`
- Mot de passe : `2026`

## Comment Changer les Identifiants

### 1. Modifier le fichier `api/auth.php`

Ouvrez le fichier `api/auth.php` et modifiez la section suivante :

```php
$ADMIN_CREDENTIALS = [
    'admin' => '2026',  // Identifiant => Mot de passe
    // Vous pouvez ajouter d'autres admins ici :
    // 'alex' => 'monmotdepasse123',
];
```

### 2. Exemples de Configuration

**Un seul administrateur :**
```php
$ADMIN_CREDENTIALS = [
    'votre_identifiant' => 'votre_mot_de_passe_securise',
];
```

**Plusieurs administrateurs :**
```php
$ADMIN_CREDENTIALS = [
    'admin' => 'MotDePasseComplexe123!',
    'alex' => 'AutreMotDePasse456!',
    'manager' => 'EncoreUnAutre789!',
];
```

## Recommandations de Sécurité

### Mot de Passe Fort
✅ Utilisez un mot de passe avec :
- Au moins 12 caractères
- Lettres majuscules et minuscules
- Chiffres
- Caractères spéciaux (!@#$%^&*)

❌ N'utilisez PAS :
- Des mots du dictionnaire
- Des dates de naissance
- Des suites simples (123456, azerty, etc.)

### Bonnes Pratiques

1. **Changez régulièrement** les mots de passe (tous les 3 mois)
2. **Ne partagez jamais** vos identifiants
3. **Utilisez des identifiants différents** pour chaque administrateur
4. **Déconnectez-vous** après chaque session
5. **Vérifiez l'URL** avant de saisir vos identifiants (https://transport.fr)

## Fonctionnalités de Sécurité

### Protection Automatique
- ✅ Session expirée après 4 heures d'inactivité
- ✅ Délai de 1 seconde entre les tentatives (anti-brute force)
- ✅ Redirection automatique si non connecté
- ✅ Vérification de session toutes les 5 minutes

### Pages Protégées
- `admin.html` - Panneau principal
- `admin-chauffeurs.html` - Gestion chauffeurs
- `admin-import-csv.html` - Import CSV

## En Cas de Problème

### Mot de Passe Oublié
1. Accédez au fichier `api/auth.php` via FTP/SSH
2. Modifiez le mot de passe directement dans le fichier
3. Enregistrez et testez la connexion

### Session Bloquée
1. Videz le cache de votre navigateur
2. Supprimez les cookies du site
3. Reconnectez-vous

### Accès Non Autorisé Détecté
1. Changez IMMÉDIATEMENT tous les mots de passe
2. Vérifiez les logs du serveur
3. Contactez votre hébergeur si nécessaire

## Support

Pour toute question de sécurité, contactez l'administrateur système.

---

**Dernière mise à jour :** Février 2026
**Version :** 1.0.0
