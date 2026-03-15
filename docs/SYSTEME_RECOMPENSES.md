# 🏆 Système de Récompenses TRANSPORT 

## Vue d'ensemble

Le système de récompenses TRANSPORT  est un système complet de badges et de rangs conçu pour motiver et récompenser les chauffeurs de la flotte.

## 📁 Fichiers du système

### 1. `assets/css/animations.css`
Contient toutes les animations CSS réutilisables :
- Animations d'entrée (fadeIn, slideIn, scaleIn)
- Effets de survol (hover-lift, hover-glow, hover-scale, hover-shine)
- Animations de badges et récompenses
- Compteurs animés
- Effets de texte (gradient, glow)
- Bordures animées

### 2. `assets/js/rewards.js`
Script JavaScript principal qui gère :
- Configuration des badges (10 badges disponibles)
- Configuration des rangs (6 niveaux)
- Affichage dynamique des badges
- Affichage des rangs avec barres de progression
- Compteurs animés
- Notifications de récompenses
- Animations au scroll

## 🎖️ Badges disponibles

| Badge | Icône | Description | Condition |
|-------|-------|-------------|-----------|
| Recrue | 🚛 | Bienvenue dans la flotte | Rejoindre  |
| Vétéran | ⭐ | Plus de 100 livraisons | 100+ livraisons |
| Expert | 🏆 | Plus de 500 livraisons | 500+ livraisons |
| Légende | 👑 | Plus de 1000 livraisons | 1000+ livraisons |
| Maître des Convois | 🚦 | Participation à 50+ convois | 50+ convois |
| Conducteur Prudent | 🛡️ | Aucun accident en 100 livraisons | 0 accident / 100 livraisons |
| Démon de la Vitesse | ⚡ | Livraison la plus rapide | Record de vitesse |
| Hibou de Nuit | 🌙 | 100 livraisons nocturnes | 100 livraisons de nuit |
| Longue Distance | 🌍 | Plus de 100 000 km parcourus | 100 000+ km |
| Esprit d'Équipe | 🤝 | Aide 50+ membres | 50+ aides |

## 📊 Système de rangs

| Niveau | Nom | Livraisons requises | Icône |
|--------|-----|---------------------|-------|
| 1 | Apprenti | 0 | 🔰 |
| 2 | Chauffeur | 50 | 🚚 |
| 3 | Routier Confirmé | 150 | 🚛 |
| 4 | Expert Logistique | 300 | ⭐ |
| 5 | Capitaine de Route | 500 | 🏆 |
| 6 | Légende  | 1000 | 👑 |

## 🎨 Classes CSS d'animation disponibles

### Animations d'entrée
```css
.animate-fade-in-up      /* Apparition depuis le bas */
.animate-fade-in-left    /* Apparition depuis la gauche */
.animate-fade-in-right   /* Apparition depuis la droite */
.animate-scale-in        /* Zoom progressif */
```

### Effets continus
```css
.animate-pulse           /* Pulsation douce */
.animate-pulse-glow      /* Pulsation lumineuse */
.animate-bounce          /* Rebond */
.animate-rotate          /* Rotation */
```

### Effets au survol
```css
.hover-lift              /* Élévation au survol */
.hover-glow              /* Lueur au survol */
.hover-scale             /* Agrandissement au survol */
.hover-shine             /* Effet de brillance au survol */
```

### Délais d'animation
```css
.delay-100   /* 0.1s */
.delay-200   /* 0.2s */
.delay-300   /* 0.3s */
.delay-400   /* 0.4s */
.delay-500   /* 0.5s */
.delay-600   /* 0.6s */
```

### Effets de texte
```css
.text-gradient           /* Texte avec dégradé animé */
.text-glow              /* Texte lumineux */
```

## 💻 Utilisation JavaScript

### Afficher les badges
```javascript
// Dans votre HTML, créez un conteneur
<div id="rewards-container"></div>

// Dans votre script
Rewards.displayRewardsBadges('rewards-container');
```

### Afficher les rangs
```javascript
// Dans votre HTML, créez un conteneur
<div id="ranks-container"></div>

// Dans votre script
Rewards.displayRanks('ranks-container');
```

### Afficher une notification de récompense
```javascript
const badge = Rewards.REWARDS_CONFIG.badges[0];
Rewards.showRewardNotification(badge);
```

### Animer un compteur
```javascript
const element = document.getElementById('counter');
Rewards.animateCounter(element, 1000, 2000); // (element, valeur cible, durée en ms)
```

### Utiliser les compteurs avec HTML
```html
<div class="counter" data-counter="150">0</div>
```

## 🔧 Intégration dans une nouvelle page

1. **Ajouter les fichiers CSS et JS dans le `<head>` :**
```html
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/animations.css">
```

2. **Ajouter le script avant la fermeture du `</body>` :**
```html
<script src="assets/js/rewards.js"></script>
```

3. **Ajouter des animations aux éléments :**
```html
<div class="animate-fade-in-up hover-lift">
    Contenu animé
</div>
```

4. **Pour afficher les récompenses :**
```html
<section>
    <h2>Badges</h2>
    <div id="rewards-container"></div>
    
    <h2>Rangs</h2>
    <div id="ranks-container"></div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        Rewards.displayRewardsBadges('rewards-container');
        Rewards.displayRanks('ranks-container');
    });
</script>
```

## 📱 Responsive

Toutes les animations et le système de récompenses sont entièrement responsive :
- Les badges s'adaptent automatiquement sur mobile (60px au lieu de 80px)
- Les compteurs ajustent leur taille (2rem au lieu de 3rem)
- Les grilles s'adaptent avec Tailwind CSS

## 🎯 Personnalisation

### Ajouter un nouveau badge
Modifiez `assets/js/rewards.js` dans la section `REWARDS_CONFIG.badges` :

```javascript
{
    id: 'nouveau_badge',
    name: 'Nom du Badge',
    icon: '🎯',
    description: 'Description du badge',
    requirement: 'Condition requise',
    color: 'from-color-500 to-color-700'
}
```

### Ajouter un nouveau rang
Modifiez `assets/js/rewards.js` dans la section `REWARDS_CONFIG.ranks` :

```javascript
{
    level: 7,
    name: 'Nouveau Rang',
    minDeliveries: 1500,
    icon: '🌟'
}
```

## 🚀 Performances

- Toutes les animations utilisent `transform` et `opacity` pour des performances optimales
- Les animations au scroll utilisent `IntersectionObserver` pour économiser les ressources
- Les compteurs sont optimisés avec `requestAnimationFrame`

## 🎨 Couleurs du thème

Le système utilise les couleurs de la charte graphique  :
- Bleu principal : `#2563eb` (blue-600)
- Jaune accent : `#fbbf24` (yellow-400)
- Fond sombre : `#0f172a` (slate-900)
- Cartes : `#1e293b` (slate-800)

## 📝 Notes importantes

1. Le système s'initialise automatiquement au chargement de la page
2. Les animations sont déclenchées au scroll pour une meilleure expérience
3. Tous les badges et rangs sont configurables via JavaScript
4. Le système est compatible avec tous les navigateurs modernes

## 🔄 Mises à jour futures

Fonctionnalités prévues :
- Intégration avec l'API Trucky pour les statistiques réelles
- Système de progression en temps réel
- Historique des badges débloqués
- Comparaison avec d'autres chauffeurs
- Badges saisonniers et événements spéciaux
