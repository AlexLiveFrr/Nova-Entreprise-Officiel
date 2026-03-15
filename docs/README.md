# 📚 Documentation TRANSPORT 

Bienvenue dans la documentation du site web TRANSPORT  !

## 📖 Table des matières

### 🎬 Système d'Animations
- **[GUIDE_ANIMATIONS.md](GUIDE_ANIMATIONS.md)** - Guide complet pour utiliser toutes les animations disponibles
  - Catalogue des animations
  - Exemples pratiques
  - Bonnes pratiques
  - Résolution de problèmes

### 🏆 Système de Récompenses
- **[SYSTEME_RECOMPENSES.md](SYSTEME_RECOMPENSES.md)** - Documentation du système de badges et rangs
  - Configuration des badges
  - Système de progression
  - API JavaScript
  - Intégration dans les pages

## 🚀 Démarrage rapide

### Pour ajouter des animations à une page

1. Inclure le CSS d'animations :
```html
<link rel="stylesheet" href="assets/css/animations.css">
```

2. Utiliser les classes sur vos éléments :
```html
<div class="animate-fade-in-up hover-lift">
    Votre contenu
</div>
```

### Pour ajouter le système de récompenses

1. Inclure les fichiers nécessaires :
```html
<link rel="stylesheet" href="assets/css/animations.css">
<script src="assets/js/rewards.js"></script>
```

2. Créer un conteneur et initialiser :
```html
<div id="rewards-container"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        Rewards.displayRewardsBadges('rewards-container');
    });
</script>
```

## 📁 Structure des fichiers

```
/
├── assets/
│   ├── css/
│   │   ├── style.css           # Styles principaux
│   │   └── animations.css      # Système d'animations
│   └── js/
│       ├── menu.js             # Menu burger
│       ├── rewards.js          # Système de récompenses
│       └── script.js           # Scripts formulaires
├── docs/
│   ├── README.md               # Ce fichier
│   ├── GUIDE_ANIMATIONS.md     # Guide des animations
│   └── SYSTEME_RECOMPENSES.md  # Doc système récompenses
├── demo-animations.html        # Page de démonstration
└── CHANGELOG_ANIMATIONS.md     # Historique des changements
```

## 🎨 Animations disponibles

### Animations d'apparition
- `animate-fade-in-up` - Depuis le bas
- `animate-fade-in-left` - Depuis la gauche
- `animate-fade-in-right` - Depuis la droite
- `animate-scale-in` - Zoom progressif

### Animations continues
- `animate-pulse` - Pulsation
- `animate-pulse-glow` - Pulsation lumineuse
- `animate-bounce` - Rebond
- `animate-rotate` - Rotation

### Effets au survol
- `hover-lift` - Élévation
- `hover-glow` - Lueur
- `hover-scale` - Agrandissement
- `hover-shine` - Brillance

### Effets de texte
- `text-gradient` - Dégradé animé
- `text-glow` - Lueur

## 🏅 Badges disponibles

| Badge | Icône | Condition |
|-------|-------|-----------|
| Recrue | 🚛 | Rejoindre  |
| Vétéran | ⭐ | 100+ livraisons |
| Expert | 🏆 | 500+ livraisons |
| Légende | 👑 | 1000+ livraisons |
| Maître des Convois | 🚦 | 50+ convois |
| Conducteur Prudent | 🛡️ | 0 accident / 100 livraisons |
| Démon de la Vitesse | ⚡ | Record de vitesse |
| Hibou de Nuit | 🌙 | 100 livraisons de nuit |
| Longue Distance | 🌍 | 100 000+ km |
| Esprit d'Équipe | 🤝 | 50+ aides |

## 🎖️ Rangs

1. Apprenti (0 livraisons) 🔰
2. Chauffeur (50 livraisons) 🚚
3. Routier Confirmé (150 livraisons) 🚛
4. Expert Logistique (300 livraisons) ⭐
5. Capitaine de Route (500 livraisons) 🏆
6. Légende  (1000 livraisons) 👑

## 🔧 API JavaScript

### Fonctions principales

```javascript
// Afficher les badges
Rewards.displayRewardsBadges('container-id');

// Afficher les rangs
Rewards.displayRanks('container-id');

// Animer un compteur
Rewards.animateCounter(element, targetValue, duration);

// Afficher une notification
Rewards.showRewardNotification(badge);
```

### Configuration

```javascript
// Accéder aux badges
Rewards.REWARDS_CONFIG.badges

// Accéder aux rangs
Rewards.REWARDS_CONFIG.ranks
```

## 📱 Responsive

Tous les systèmes sont entièrement responsive :
- Animations adaptées sur mobile
- Badges redimensionnés automatiquement
- Grilles responsive avec Tailwind CSS

## 🎯 Exemples d'utilisation

### Carte avec animations
```html
<div class="bg-slate-800 p-8 rounded-xl hover-lift hover-shine animate-fade-in-up">
    <div class="text-4xl mb-4 animate-bounce">🚛</div>
    <h3 class="text-2xl font-bold text-yellow-400">Titre</h3>
    <p class="text-gray-300">Description</p>
</div>
```

### Bouton animé
```html
<button class="bg-blue-600 text-white px-8 py-4 rounded-lg hover-lift animate-pulse-glow">
    Cliquez-moi
</button>
```

### Compteur animé
```html
<div class="counter text-yellow-400" data-counter="150">0</div>
```

### Section avec titre animé
```html
<section class="py-20">
    <h2 class="text-5xl font-black animate-fade-in-up">
        <span class="text-gradient text-glow">Titre impressionnant</span>
    </h2>
</section>
```

## 🎓 Ressources d'apprentissage

1. **Commencer** : Lire [GUIDE_ANIMATIONS.md](GUIDE_ANIMATIONS.md)
2. **Approfondir** : Lire [SYSTEME_RECOMPENSES.md](SYSTEME_RECOMPENSES.md)
3. **Pratiquer** : Ouvrir `demo-animations.html` dans le navigateur
4. **Référence** : Consulter les pages déjà mises à jour (index.html, pourquoinouschoisir.html, etc.)

## 🐛 Résolution de problèmes

### Les animations ne fonctionnent pas
1. Vérifier que `animations.css` est bien chargé
2. Vérifier la console pour les erreurs
3. S'assurer que les classes sont correctement écrites

### Les compteurs ne s'animent pas
1. Vérifier que `rewards.js` est chargé
2. S'assurer que l'attribut `data-counter` est présent
3. Vérifier que le script s'exécute après le chargement du DOM

### Les badges ne s'affichent pas
1. Vérifier que le conteneur existe
2. Vérifier que la fonction est appelée après le chargement
3. Consulter la console pour les erreurs JavaScript

## 💡 Bonnes pratiques

1. **Performance** : Ne pas abuser des animations continues
2. **Cohérence** : Utiliser les mêmes animations pour des éléments similaires
3. **Subtilité** : Moins c'est souvent mieux
4. **Accessibilité** : Tester sur différents appareils
5. **Mobile** : Vérifier que tout fonctionne sur mobile

## 🔄 Mises à jour

Consultez [CHANGELOG_ANIMATIONS.md](../CHANGELOG_ANIMATIONS.md) pour l'historique des changements.

## 📞 Support

Pour toute question :
1. Consulter cette documentation
2. Tester sur `demo-animations.html`
3. Vérifier la console du navigateur
4. Contacter l'équipe de développement

## 🌟 Contribuer

Pour ajouter de nouvelles animations ou badges :
1. Modifier `assets/css/animations.css` pour les animations CSS
2. Modifier `assets/js/rewards.js` pour les badges/rangs
3. Mettre à jour cette documentation
4. Tester sur `demo-animations.html`

## 📊 Statistiques

- **Animations CSS** : 20+
- **Badges disponibles** : 10
- **Rangs disponibles** : 6
- **Pages mises à jour** : 5
- **Documentation** : 3 fichiers
- **Compatibilité** : 100% navigateurs modernes

## 🎉 Fonctionnalités

### Actuellement disponibles
- ✅ Système d'animations complet
- ✅ Système de badges et rangs
- ✅ Compteurs animés
- ✅ Notifications
- ✅ Animations au scroll
- ✅ Effets au survol
- ✅ Documentation complète

### À venir
- 🔜 Intégration API Trucky
- 🔜 Progression en temps réel
- 🔜 Badges saisonniers
- 🔜 Classements
- 🔜 Profils de chauffeurs

---

**Dernière mise à jour** : 8 février 2026  
**Version** : 1.0  
**Maintenu par** : Équipe TRANSPORT 
