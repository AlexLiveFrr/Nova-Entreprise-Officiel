# 🚀 Guide de Démarrage Rapide - Système TruckBook

## ⚡ Installation en 5 minutes

### Étape 1 : Importer la base de données (2 min)

**Option A : Via phpMyAdmin**
1. Ouvrir http://localhost/phpmyadmin
2. Cliquer sur votre base `_db` (à gauche)
3. Onglet "Importer" (en haut)
4. Cliquer sur "Choisir un fichier"
5. Sélectionner `api/db-setup-truckbook.sql`
6. Cliquer sur "Exécuter" (en bas)
7. ✅ Vous devriez voir "Importation réussie"

**Option B : Via ligne de commande**
```bash
cd c:\wamp64\www\SiteETS\
mysql -u root -p _db < api\db-setup-truckbook.sql
```

### Étape 2 : Vérifier la configuration (30 sec)

Ouvrir `api/config.php` et vérifier :
```php
$host = 'localhost';
$dbname = '_db';  // ← Votre base de données
$user = 'root';
$pass = '';            // ← Votre mot de passe MySQL
```

### Étape 3 : Tester le système (2 min)

1. **Ouvrir l'interface admin**
   ```
   http://localhost/SiteETS//admin-chauffeurs.html
   ```

2. **Ajouter un chauffeur de test**
   - Cliquer sur "➕ Ajouter un chauffeur"
   - Pseudo : "Test"
   - Cliquer sur "✅ Ajouter"
   - ✅ Vous devriez voir "Chauffeur ajouté avec succès !"

3. **Modifier ses stats**
   - Cliquer sur "📊 Stats" sur le chauffeur Test
   - Mettre 150 livraisons
   - Mettre 25000 kilomètres
   - Cliquer sur "💾 Sauvegarder"
   - ✅ Vous devriez voir "Statistiques mises à jour !"
   - 🎉 Le badge "Vétéran" devrait se débloquer !

4. **Voir la page équipe**
   ```
   http://localhost/SiteETS//equipe.html
   ```
   ✅ Vous devriez voir votre chauffeur Test dans le classement

5. **Voir son profil**
   - Cliquer sur "Voir profil" sur le chauffeur Test
   ✅ Vous devriez voir toutes ses stats et badges

---

## 🎯 Utilisation quotidienne

### Ajouter un nouveau chauffeur

1. Ouvrir `admin-chauffeurs.html`
2. Cliquer sur "➕ Ajouter un chauffeur"
3. Remplir :
   - **Pseudo** (obligatoire)
   - **Discord ID** (ex: AlexLive#1234)
   - **Steam ID** (ex: 76561198...)
   - **Lien TruckBook** (ex: https://trucksbook.eu/profile/123)
   - **URL Avatar** (optionnel)
   - **Rôle** (chauffeur/staff/admin)
4. Cliquer sur "✅ Ajouter"

### Mettre à jour les stats d'un chauffeur

1. Ouvrir `admin-chauffeurs.html`
2. Trouver le chauffeur dans la liste
3. Cliquer sur "📊 Stats"
4. Mettre à jour les valeurs :
   - 🚛 Livraisons
   - 🌍 Kilomètres
   - ⏱️ Heures de jeu
   - 🚦 Convois participés
   - 💥 Accidents
   - 🌙 Livraisons de nuit
5. Cliquer sur "💾 Sauvegarder"
6. 🎉 Les nouveaux badges se débloquent automatiquement !

---

## 🏅 Badges et déblocage

### Badges automatiques

Les badges se débloquent **automatiquement** quand vous mettez à jour les stats :

| Badge | Condition | Se débloque quand |
|-------|-----------|-------------------|
| 🚛 Recrue | Automatique | À l'inscription |
| ⭐ Vétéran | 100 livraisons | Vous mettez ≥ 100 livraisons |
| 🏆 Expert | 500 livraisons | Vous mettez ≥ 500 livraisons |
| 👑 Légende | 1000 livraisons | Vous mettez ≥ 1000 livraisons |
| 🚦 Maître des Convois | 50 convois | Vous mettez ≥ 50 convois |
| 🌙 Hibou de Nuit | 100 livraisons nuit | Vous mettez ≥ 100 livraisons nuit |
| 🌍 Longue Distance | 100 000 km | Vous mettez ≥ 100 000 km |
| 🛡️ Conducteur Prudent | 0 accident + 100 livraisons | 0 accident ET ≥ 100 livraisons |

### Rangs automatiques

Les rangs changent automatiquement selon les livraisons :

| Rang | Livraisons | Icône |
|------|------------|-------|
| Apprenti | 0-49 | 🔰 |
| Chauffeur | 50-149 | 🚚 |
| Routier Confirmé | 150-299 | 🚛 |
| Expert Logistique | 300-499 | ⭐ |
| Capitaine de Route | 500-999 | 🏆 |
| Légende  | 1000+ | 👑 |

---

## 📊 Où récupérer les stats ?

### Sur TruckBook

1. Aller sur le profil TruckBook du chauffeur
   ```
   https://trucksbook.eu/profile/[ID]
   ```

2. Noter les stats :
   - **Livraisons** : Total des jobs
   - **Kilomètres** : Distance totale
   - **Heures** : Temps de jeu
   - **Convois** : Nombre de convois (si disponible)

3. Mettre à jour dans `admin-chauffeurs.html`

### Fréquence de mise à jour

**Recommandé :**
- 📅 **Hebdomadaire** : Pour les chauffeurs actifs
- 📅 **Mensuel** : Pour les chauffeurs occasionnels
- 📅 **Après chaque convoi** : Pour les convois participés

---

## 🎨 Pages disponibles

### Pour les visiteurs

**equipe.html** - Page publique
- Classement des chauffeurs
- Statistiques globales
- Podium Top 3
- Filtres par catégorie

**profil-chauffeur.html?id=X** - Profil public
- Stats détaillées du chauffeur
- Badges obtenus
- Progression vers prochain rang
- Liens TruckBook/Steam

### Pour les admins

**admin-chauffeurs.html** - Interface admin
- Ajouter des chauffeurs
- Modifier les stats
- Voir la liste complète
- Gérer l'équipe

---

## ⚙️ Workflow recommandé

### 1. Nouveau membre recruté

```
1. Membre accepté sur Discord
2. Admin → admin-chauffeurs.html
3. ➕ Ajouter un chauffeur
4. Remplir ses infos (pseudo, Discord, TruckBook)
5. ✅ Ajouter
```

### 2. Mise à jour régulière (chaque semaine)

```
1. Admin → Vérifier TruckBook de chaque membre
2. admin-chauffeurs.html
3. 📊 Stats sur chaque chauffeur
4. Mettre à jour les valeurs
5. 💾 Sauvegarder
6. 🎉 Nouveaux badges débloqués !
```

### 3. Après un convoi

```
1. Convoi terminé
2. admin-chauffeurs.html
3. Pour chaque participant :
   - 📊 Stats
   - +1 dans "Convois"
   - 💾 Sauvegarder
```

---

## 💡 Astuces

### Astuce 1 : Mise à jour rapide
Au lieu de mettre à jour tous les champs, mettez à jour seulement ce qui a changé.
Par exemple, après un convoi : juste +1 convoi.

### Astuce 2 : Badge "Recrue"
Le badge "Recrue" 🚛 est attribué automatiquement à l'inscription.
Vous n'avez rien à faire !

### Astuce 3 : Voir les nouveaux badges
Quand vous sauvegardez les stats, si un nouveau badge est débloqué,
il s'affiche immédiatement dans une notification verte 🎉

### Astuce 4 : Classement en temps réel
Dès que vous mettez à jour les stats, le classement sur `equipe.html`
est mis à jour automatiquement (rafraîchir la page).

### Astuce 5 : Liens directs
Vous pouvez partager directement le lien du profil d'un chauffeur :
```
https://votre-site.com/profil-chauffeur.html?id=5
```

---

## 🔗 Liens rapides

```
Interface Admin    : admin-chauffeurs.html
Page Équipe        : equipe.html
Profil Chauffeur   : profil-chauffeur.html?id=X
Documentation      : docs/SYSTEME_TRUCKBOOK_COMPLET.md
```

---

## ✅ Checklist première utilisation

- [ ] Base de données importée
- [ ] config.php vérifié
- [ ] Chauffeur de test ajouté
- [ ] Stats de test modifiées
- [ ] Badge "Vétéran" débloqué (test avec 100 livraisons)
- [ ] Page equipe.html fonctionne
- [ ] Profil chauffeur fonctionne
- [ ] Tout fonctionne parfaitement !

---

## 🆘 Problèmes courants

### "Erreur de connexion à la base de données"
✅ **Solution** : Vérifier `api/config.php` et que MySQL est démarré

### "Chauffeur non trouvé"
✅ **Solution** : Vérifier que l'ID existe et que le statut est "actif"

### Les badges ne se débloquent pas
✅ **Solution** : Vérifier que les triggers SQL sont bien importés
```sql
SHOW TRIGGERS; -- Dans phpMyAdmin
```

### La page est blanche
✅ **Solution** : Ouvrir la console (F12) et regarder les erreurs

---

## 🎉 C'est parti !

Vous êtes prêt à utiliser le système TruckBook !

**Prochaines étapes :**
1. Ajouter vos vrais chauffeurs
2. Mettre à jour leurs stats depuis TruckBook
3. Partager la page `equipe.html` avec votre communauté
4. Profiter du système de badges automatique !

**Bon courage ! 🚛✨**

---

**Besoin d'aide ?**
Consultez `docs/SYSTEME_TRUCKBOOK_COMPLET.md` pour la documentation complète.
