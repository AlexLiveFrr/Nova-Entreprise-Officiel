# 🚛 Système TruckBook Complet - Documentation

## 📋 Vue d'ensemble

Système complet de gestion des chauffeurs avec badges, rangs, profils et classement pour TRANSPORT .

---

## 🗄️ Base de données

### Tables créées

#### 1. **chauffeurs**
Informations principales des chauffeurs
```sql
- id (PK)
- pseudo
- discord_id
- steam_id
- truckbook_url
- truckersmp_id
- avatar_url
- date_inscription
- statut (actif/inactif/en_pause)
- role (chauffeur/staff/admin)
```

#### 2. **chauffeur_stats**
Statistiques de chaque chauffeur
```sql
- id (PK)
- chauffeur_id (FK)
- livraisons
- kilometres
- heures_jeu
- convois_participes
- accidents
- livraisons_nuit
- derniere_livraison
```

#### 3. **badges**
Liste des badges disponibles
```sql
- id (PK)
- code (unique)
- nom
- description
- icone
- condition_type
- condition_valeur
- couleur
- ordre
- actif
```

#### 4. **chauffeur_badges**
Badges obtenus par les chauffeurs
```sql
- id (PK)
- chauffeur_id (FK)
- badge_id (FK)
- date_obtention
```

#### 5. **rangs**
Système de progression
```sql
- id (PK)
- niveau
- nom
- icone
- livraisons_requises
- couleur
```

#### 6. **historique_stats**
Historique des modifications
```sql
- id (PK)
- chauffeur_id (FK)
- livraisons_avant/apres
- kilometres_avant/apres
- date_mise_a_jour
- mis_a_jour_par
```

---

## 🏅 Badges disponibles

| Code | Nom | Icône | Condition | Couleur |
|------|-----|-------|-----------|---------|
| rookie | Recrue | 🚛 | Rejoindre | Gris |
| veteran | Vétéran | ⭐ | 100 livraisons | Bleu |
| expert | Expert | 🏆 | 500 livraisons | Violet |
| legend | Légende | 👑 | 1000 livraisons | Or |
| convoy_master | Maître des Convois | 🚦 | 50 convois | Vert |
| safe_driver | Conducteur Prudent | 🛡️ | 0 accident/100 livraisons | Cyan |
| night_owl | Hibou de Nuit | 🌙 | 100 livraisons nuit | Indigo |
| long_haul | Longue Distance | 🌍 | 100 000 km | Teal |
| founding_member | Membre Fondateur | 💎 | Spécial | Rose |
| active_member | Membre Actif | ⚡ | 6 mois ancienneté | Orange |

---

## 🎖️ Système de rangs

| Niveau | Nom | Icône | Livraisons | Couleur |
|--------|-----|-------|------------|---------|
| 1 | Apprenti | 🔰 | 0 | Gris |
| 2 | Chauffeur | 🚚 | 50 | Bleu |
| 3 | Routier Confirmé | 🚛 | 150 | Vert |
| 4 | Expert Logistique | ⭐ | 300 | Violet |
| 5 | Capitaine de Route | 🏆 | 500 | Jaune |
| 6 | Légende  | 👑 | 1000 | Rouge |

---

## 📁 Fichiers créés

### Base de données
```
api/db-setup-truckbook.sql          - Script SQL complet
```

### API PHP
```
api/chauffeurs-get.php              - Récupérer les chauffeurs
api/chauffeurs-add.php              - Ajouter un chauffeur
api/chauffeurs-update-stats.php     - Mettre à jour les stats
```

### Pages HTML
```
equipe.html                         - Page équipe avec classement
profil-chauffeur.html               - Profil détaillé d'un chauffeur
admin-chauffeurs.html               - Interface admin
```

---

## 🚀 Installation

### Étape 1 : Base de données

```bash
# Importer le script SQL
mysql -u root -p _db < api/db-setup-truckbook.sql
```

Ou via phpMyAdmin :
1. Ouvrir phpMyAdmin
2. Sélectionner la base `_db`
3. Onglet "Importer"
4. Choisir `api/db-setup-truckbook.sql`
5. Exécuter

### Étape 2 : Vérifier config.php

```php
// api/config.php doit contenir :
$host = 'localhost';
$dbname = '_db';
$user = 'root';
$pass = '';
```

### Étape 3 : Tester

1. Ouvrir `admin-chauffeurs.html`
2. Ajouter un chauffeur de test
3. Mettre à jour ses stats
4. Voir sur `equipe.html`
5. Voir son profil sur `profil-chauffeur.html`

---

## 💻 Utilisation

### Interface Admin

**URL :** `admin-chauffeurs.html`

**Fonctionnalités :**
- ➕ Ajouter un nouveau chauffeur
- 📊 Modifier les statistiques
- 👁️ Voir le profil
- 🔄 Actualiser la liste

**Ajouter un chauffeur :**
1. Cliquer sur "➕ Ajouter un chauffeur"
2. Remplir le formulaire :
   - Pseudo (requis)
   - Discord ID (optionnel)
   - Steam ID (optionnel)
   - Lien TruckBook (optionnel)
   - URL Avatar (optionnel)
   - Rôle (chauffeur/staff/admin)
3. Cliquer sur "✅ Ajouter"

**Modifier les stats :**
1. Cliquer sur "📊 Stats" sur un chauffeur
2. Modifier les valeurs :
   - 🚛 Livraisons
   - 🌍 Kilomètres
   - ⏱️ Heures de jeu
   - 🚦 Convois
   - 💥 Accidents
   - 🌙 Livraisons nuit
3. Cliquer sur "💾 Sauvegarder"
4. Les badges se débloquent automatiquement !

### Page Équipe

**URL :** `equipe.html`

**Fonctionnalités :**
- 📊 Statistiques globales
- 🏆 Classement des chauffeurs
- 🥇 Podium Top 3
- 🔍 Filtres (livraisons/km/convois)
- 👁️ Voir profil de chaque chauffeur

### Page Profil

**URL :** `profil-chauffeur.html?id=X`

**Affiche :**
- 👤 Infos du chauffeur
- 📊 Statistiques détaillées
- 🏅 Badges obtenus
- 🎖️ Rang actuel
- 🎯 Progression vers prochain rang
- 🔗 Liens TruckBook/Steam

---

## 🔧 API

### GET - Récupérer les chauffeurs

```javascript
// Tous les chauffeurs
fetch('api/chauffeurs-get.php')

// Un chauffeur spécifique
fetch('api/chauffeurs-get.php?id=1')

// Avec filtres
fetch('api/chauffeurs-get.php?statut=actif&limit=50')
```

**Réponse :**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "pseudo": "Alex",
      "livraisons": 250,
      "kilometres": 45000,
      "rang_nom": "Routier Confirmé",
      "rang_icone": "🚛",
      "nombre_badges": 5
    }
  ]
}
```

### POST - Ajouter un chauffeur

```javascript
fetch('api/chauffeurs-add.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    pseudo: 'NouveauChauffeur',
    discord_id: '123456789',
    steam_id: '76561198...',
    truckbook_url: 'https://trucksbook.eu/...',
    role: 'chauffeur'
  })
})
```

### POST - Mettre à jour les stats

```javascript
fetch('api/chauffeurs-update-stats.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    chauffeur_id: 1,
    livraisons: 300,
    kilometres: 50000,
    convois_participes: 15,
    mis_a_jour_par: 'admin'
  })
})
```

**Réponse avec nouveaux badges :**
```json
{
  "success": true,
  "message": "Statistiques mises à jour",
  "nouveaux_badges": [
    {
      "nom": "Routier Confirmé",
      "icone": "🚛"
    }
  ]
}
```

---

## ⚙️ Attribution automatique des badges

Les badges sont attribués **automatiquement** via des triggers SQL :

### Triggers actifs

1. **after_stats_update** : Vérifie et attribue les badges après chaque mise à jour
2. **after_chauffeur_insert** : Attribue le badge "Recrue" à l'inscription

### Conditions vérifiées

- ✅ Vétéran : 100 livraisons
- ✅ Expert : 500 livraisons
- ✅ Légende : 1000 livraisons
- ✅ Maître des Convois : 50 convois
- ✅ Hibou de Nuit : 100 livraisons nuit
- ✅ Longue Distance : 100 000 km
- ✅ Conducteur Prudent : 0 accident avec 100+ livraisons

---

## 📊 Vues SQL disponibles

### v_classement_chauffeurs
Classement complet avec toutes les infos

```sql
SELECT * FROM v_classement_chauffeurs;
```

### v_chauffeur_badges
Badges de tous les chauffeurs

```sql
SELECT * FROM v_chauffeur_badges WHERE chauffeur_id = 1;
```

---

## 🎨 Personnalisation

### Ajouter un nouveau badge

```sql
INSERT INTO badges (code, nom, description, icone, condition_type, condition_valeur, couleur) 
VALUES ('nouveau_badge', 'Nom du Badge', 'Description', '🎯', 'livraisons', 750, 'from-red-500 to-red-700');
```

### Modifier un rang

```sql
UPDATE rangs SET livraisons_requises = 200 WHERE niveau = 3;
```

### Ajouter une condition au trigger

```sql
-- Éditer le trigger after_stats_update
-- Ajouter une nouvelle condition IF
```

---

## 🔐 Sécurité

### Recommandations

1. **Protéger l'interface admin**
   - Ajouter un système de connexion
   - Vérifier les permissions
   - Utiliser des sessions PHP

2. **Valider les données**
   - Toutes les API valident les entrées
   - Protection contre les injections SQL (PDO)
   - Échappement des données

3. **Limiter l'accès**
   - Restreindre l'accès à `admin-chauffeurs.html`
   - Utiliser `.htaccess` ou authentification

---

## 📱 Responsive

Toutes les pages sont 100% responsive :
- ✅ Desktop
- ✅ Tablette
- ✅ Mobile

---

## 🎯 Workflow complet

### 1. Recrutement
```
Candidat postule → Formulaire contact.html → Discord
```

### 2. Ajout dans le système
```
Admin → admin-chauffeurs.html → Ajouter chauffeur
```

### 3. Mise à jour régulière
```
Admin vérifie TruckBook → Met à jour stats → Badges automatiques
```

### 4. Affichage public
```
Visiteur → equipe.html → Voir classement → profil-chauffeur.html
```

---

## 🔄 Mises à jour des stats

### Méthode manuelle (actuelle)

1. Admin ouvre `admin-chauffeurs.html`
2. Vérifie les stats sur TruckBook
3. Met à jour manuellement
4. Badges attribués automatiquement

### Méthode semi-automatique (future)

1. Créer un script qui récupère les stats TruckBook
2. Mettre à jour automatiquement via l'API
3. Lancer le script quotidiennement (cron)

---

## 📈 Statistiques disponibles

### Globales (equipe.html)
- Total chauffeurs actifs
- Total livraisons
- Total kilomètres
- Total convois

### Par chauffeur (profil-chauffeur.html)
- Livraisons
- Kilomètres
- Heures de jeu
- Convois participés
- Accidents
- Livraisons de nuit
- Dernière livraison
- Badges obtenus
- Rang actuel
- Progression

---

## 🐛 Résolution de problèmes

### Erreur "Chauffeur non trouvé"
- Vérifier que l'ID existe dans la base
- Vérifier que le statut est "actif"

### Les badges ne se débloquent pas
- Vérifier que les triggers sont actifs
- Vérifier les conditions dans la table `badges`
- Regarder les logs MySQL

### Les stats ne s'affichent pas
- Vérifier que `chauffeur_stats` a des données
- Vérifier la connexion à la base de données
- Regarder la console du navigateur (F12)

---

## 📞 Support

Pour toute question :
1. Consulter cette documentation
2. Vérifier les logs MySQL
3. Vérifier la console du navigateur (F12)
4. Tester les API directement

---

## ✅ Checklist de déploiement

- [ ] Importer `db-setup-truckbook.sql`
- [ ] Vérifier `config.php`
- [ ] Tester l'ajout d'un chauffeur
- [ ] Tester la mise à jour des stats
- [ ] Vérifier que les badges se débloquent
- [ ] Tester `equipe.html`
- [ ] Tester `profil-chauffeur.html`
- [ ] Protéger `admin-chauffeurs.html`
- [ ] Ajouter vos chauffeurs existants

---

**Version** : 1.0  
**Date** : 8 février 2026  
**Statut** : ✅ Système complet et fonctionnel
