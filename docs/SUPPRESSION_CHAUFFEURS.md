# 🗑️ Suppression de Chauffeurs

## Fonctionnalité

La fonctionnalité de suppression permet de retirer définitivement un chauffeur de la base de données via l'interface d'administration.

## ⚠️ Avertissements

**ATTENTION : La suppression est IRRÉVERSIBLE !**

Lorsqu'un chauffeur est supprimé :
- ✅ Toutes ses statistiques sont supprimées
- ✅ Tous ses badges sont supprimés
- ✅ Son historique est supprimé
- ❌ **Aucune récupération possible**

## 🎯 Utilisation

### Via l'interface Admin

1. Allez sur `admin-chauffeurs.html`
2. Trouvez le chauffeur à supprimer
3. Cliquez sur le bouton **🗑️** (rouge)
4. Une modal de confirmation s'affiche
5. Vérifiez le nom du chauffeur
6. Cliquez sur **"Supprimer"** pour confirmer
7. Le chauffeur est supprimé et la liste est actualisée

### Via l'API

**Endpoint :** `api/chauffeurs-delete.php`

**Méthodes acceptées :**
- `DELETE` : ID dans l'URL (`?id=123`)
- `POST` : ID dans le body JSON

**Exemple avec POST :**
```javascript
fetch('api/chauffeurs-delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: 123 })
})
.then(res => res.json())
.then(data => console.log(data));
```

**Exemple avec DELETE :**
```javascript
fetch('api/chauffeurs-delete.php?id=123', {
    method: 'DELETE'
})
.then(res => res.json())
.then(data => console.log(data));
```

## 📋 Réponses API

### Succès
```json
{
    "success": true,
    "message": "Chauffeur supprimé avec succès",
    "data": {
        "id": 123,
        "pseudo": "JohnDoe",
        "avatar_url": "...",
        "livraisons": 150,
        "kilometres": 25000,
        "nombre_badges": 5
    }
}
```

### Erreur - Chauffeur non trouvé
```json
{
    "success": false,
    "message": "Chauffeur non trouvé"
}
```

### Erreur - ID manquant
```json
{
    "success": false,
    "message": "ID du chauffeur requis"
}
```

### Erreur - Base de données
```json
{
    "success": false,
    "message": "Erreur de base de données",
    "error": "..."
}
```

## 🔒 Sécurité

### Base de données
- Utilise des requêtes préparées (PDO)
- Protection contre les injections SQL
- Cascade de suppression automatique (ON DELETE CASCADE)

### Recommandations
- ⚠️ Ajouter une authentification admin
- ⚠️ Logger les suppressions
- ⚠️ Créer des sauvegardes régulières
- ⚠️ Limiter l'accès à l'interface admin

## 🛠️ Fichiers modifiés

1. **api/chauffeurs-delete.php** (nouveau)
   - API de suppression
   - Gestion des erreurs
   - Validation de l'ID

2. **admin-chauffeurs.html** (modifié)
   - Bouton de suppression ajouté
   - Modal de confirmation
   - Fonctions JavaScript

## 📦 Installation

### 1. Uploader les fichiers
```
api/chauffeurs-delete.php  → /home/transcs/www/api/
admin-chauffeurs.html      → /home/transcs/www/
```

### 2. Vérifier les permissions
Les tables doivent avoir `ON DELETE CASCADE` :
```sql
FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id) ON DELETE CASCADE
```

### 3. Tester
1. Créer un chauffeur de test
2. Le supprimer via l'interface
3. Vérifier qu'il a bien disparu

## 🧪 Tests recommandés

- [ ] Supprimer un chauffeur sans stats
- [ ] Supprimer un chauffeur avec stats
- [ ] Supprimer un chauffeur avec badges
- [ ] Tenter de supprimer un ID inexistant
- [ ] Vérifier que les stats sont bien supprimées
- [ ] Vérifier que les badges sont bien supprimés

## 🔄 Alternatives à la suppression

Au lieu de supprimer définitivement, vous pouvez :

1. **Désactiver le chauffeur** (statut = 'inactif')
2. **Archiver les données** dans une table séparée
3. **Soft delete** avec un champ `deleted_at`

## 📞 Support

En cas de problème :
1. Vérifier les logs PHP
2. Tester l'API directement
3. Vérifier la console du navigateur
4. Consulter `diagnostic-truckbook.html`
