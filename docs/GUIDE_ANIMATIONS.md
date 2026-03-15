# 🎬 Guide des Animations TRANSPORT 

## Introduction

Ce guide explique comment utiliser le système d'animations pour rendre votre site web plus dynamique et professionnel.

## 🚀 Démarrage rapide

### 1. Inclure le fichier CSS

Ajoutez cette ligne dans le `<head>` de votre page HTML :

```html
<link rel="stylesheet" href="assets/css/animations.css">
```

### 2. Inclure le fichier JavaScript (optionnel)

Pour les fonctionnalités avancées (compteurs, notifications), ajoutez avant `</body>` :

```html
<script src="assets/js/rewards.js"></script>
```

## 📚 Catalogue des animations

### 🎭 Animations d'apparition

#### Fade In Up (Apparition depuis le bas)
```html
<div class="animate-fade-in-up">
    Ce contenu apparaît en montant
</div>
```

#### Fade In Left (Apparition depuis la gauche)
```html
<div class="animate-fade-in-left">
    Ce contenu apparaît depuis la gauche
</div>
```

#### Fade In Right (Apparition depuis la droite)
```html
<div class="animate-fade-in-right">
    Ce contenu apparaît depuis la droite
</div>
```

#### Scale In (Zoom progressif)
```html
<div class="animate-scale-in">
    Ce contenu apparaît avec un zoom
</div>
```

### ⏱️ Délais d'animation

Créez des effets en cascade en ajoutant des délais :

```html
<div class="animate-fade-in-up delay-100">Apparaît en premier</div>
<div class="animate-fade-in-up delay-200">Apparaît ensuite</div>
<div class="animate-fade-in-up delay-300">Apparaît en dernier</div>
```

Délais disponibles : `delay-100`, `delay-200`, `delay-300`, `delay-400`, `delay-500`, `delay-600`

### 🔄 Animations continues

#### Pulsation
```html
<div class="animate-pulse">
    Pulsation douce
</div>
```

#### Pulsation lumineuse
```html
<button class="animate-pulse-glow">
    Bouton avec effet lumineux
</button>
```

#### Rebond
```html
<div class="animate-bounce">
    🎯 Icône qui rebondit
</div>
```

#### Rotation
```html
<div class="animate-rotate">
    ⚙️ Icône qui tourne
</div>
```

### 🖱️ Effets au survol

#### Élévation
```html
<div class="hover-lift">
    Cette carte s'élève au survol
</div>
```

#### Lueur
```html
<div class="hover-glow">
    Cette carte brille au survol
</div>
```

#### Agrandissement
```html
<div class="hover-scale">
    Cette image s'agrandit au survol
</div>
```

#### Brillance
```html
<div class="hover-shine">
    Effet de brillance qui traverse l'élément
</div>
```

### ✨ Effets de texte

#### Texte avec dégradé animé
```html
<h1 class="text-gradient">
    Titre avec dégradé doré animé
</h1>
```

#### Texte lumineux
```html
<h2 class="text-glow">
    Texte avec effet de lueur
</h2>
```

### 🎯 Badges de récompense

```html
<div class="reward-badge">
    <span class="reward-badge-icon">🏆</span>
</div>
```

### 📊 Compteurs animés

```html
<!-- Méthode 1 : Avec attribut data -->
<div class="counter" data-counter="1000">0</div>

<!-- Méthode 2 : Avec JavaScript -->
<div id="mon-compteur" class="counter">0</div>
<script>
    const element = document.getElementById('mon-compteur');
    Rewards.animateCounter(element, 500, 2000);
</script>
```

## 🎨 Exemples pratiques

### Carte de service animée

```html
<div class="bg-slate-800 p-8 rounded-xl hover-lift hover-shine animate-fade-in-up delay-100">
    <div class="text-4xl mb-4 animate-bounce">🚛</div>
    <h3 class="text-2xl font-bold text-yellow-400">Transport Express</h3>
    <p class="text-gray-300 mt-4">Service de livraison rapide et fiable</p>
</div>
```

### Bouton call-to-action

```html
<button class="bg-blue-600 text-white px-8 py-4 rounded-lg hover-lift animate-pulse-glow">
    Rejoindre maintenant
</button>
```

### Section avec titre animé

```html
<section class="py-20">
    <h2 class="text-5xl font-black text-center animate-fade-in-up">
        <span class="text-gradient">Nos Services</span>
    </h2>
    <p class="text-center text-gray-400 mt-4 animate-fade-in-up delay-200">
        Découvrez ce que nous offrons
    </p>
</section>
```

### Grille de cartes avec animation en cascade

```html
<div class="grid md:grid-cols-3 gap-8">
    <div class="card hover-lift animate-fade-in-up delay-100">Carte 1</div>
    <div class="card hover-lift animate-fade-in-up delay-200">Carte 2</div>
    <div class="card hover-lift animate-fade-in-up delay-300">Carte 3</div>
</div>
```

### Image avec effet de zoom au survol

```html
<div class="overflow-hidden rounded-xl">
    <img src="image.jpg" alt="Description" class="hover-scale">
</div>
```

### Statistiques avec compteurs

```html
<div class="grid grid-cols-2 md:grid-cols-4 gap-8">
    <div class="text-center animate-fade-in-up delay-100">
        <div class="counter text-yellow-400" data-counter="150">0</div>
        <p class="text-gray-400 mt-2">Membres</p>
    </div>
    <div class="text-center animate-fade-in-up delay-200">
        <div class="counter text-blue-400" data-counter="5000">0</div>
        <p class="text-gray-400 mt-2">Livraisons</p>
    </div>
    <div class="text-center animate-fade-in-up delay-300">
        <div class="counter text-purple-400" data-counter="250">0</div>
        <p class="text-gray-400 mt-2">Convois</p>
    </div>
    <div class="text-center animate-fade-in-up delay-400">
        <div class="counter text-green-400" data-counter="3">0</div>
        <p class="text-gray-400 mt-2">Années</p>
    </div>
</div>
```

## 🎯 Combinaisons recommandées

### Carte de produit/service
```html
<div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover-lift hover-shine animate-fade-in-up">
    <!-- Contenu -->
</div>
```

### Bouton important
```html
<button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover-lift animate-pulse-glow">
    Action importante
</button>
```

### Titre de section
```html
<h2 class="text-4xl font-black animate-fade-in-up">
    <span class="text-gradient text-glow">Titre impressionnant</span>
</h2>
```

### Navigation/Menu
```html
<nav class="animate-fade-in-up">
    <a href="#" class="hover-lift">Lien 1</a>
    <a href="#" class="hover-lift">Lien 2</a>
</nav>
```

## 🎬 Animations au scroll

Les animations avec la classe `card-animated` se déclenchent automatiquement au scroll :

```html
<div class="card-animated">
    Ce contenu s'anime quand il devient visible
</div>
```

## ⚡ Optimisation des performances

### Bonnes pratiques

1. **Limitez les animations continues** : N'utilisez pas trop d'éléments avec `animate-pulse` ou `animate-rotate` sur une même page
2. **Utilisez les délais intelligemment** : Créez des cascades fluides sans surcharger
3. **Privilégiez les animations au survol** : Elles ne consomment des ressources que lors de l'interaction

### Désactiver une animation sur mobile

```html
<div class="hidden md:animate-bounce">
    Animation uniquement sur desktop
</div>
```

## 🎨 Personnalisation

### Modifier la durée d'une animation

```html
<style>
    .mon-element {
        animation-duration: 1s; /* Au lieu de 0.6s par défaut */
    }
</style>
```

### Créer une animation personnalisée

```css
@keyframes mon-animation {
    from { opacity: 0; transform: translateX(-100px); }
    to { opacity: 1; transform: translateX(0); }
}

.ma-classe {
    animation: mon-animation 0.8s ease-out;
}
```

## 🐛 Résolution de problèmes

### L'animation ne se déclenche pas
- Vérifiez que `animations.css` est bien chargé
- Vérifiez qu'il n'y a pas de conflit avec d'autres CSS
- Assurez-vous que l'élément est visible

### L'animation se répète en boucle
- Utilisez `animation-iteration-count: 1` pour une seule exécution
- Ou utilisez les classes prévues qui ne se répètent pas

### Les compteurs ne s'animent pas
- Vérifiez que `rewards.js` est chargé
- Assurez-vous que l'attribut `data-counter` est présent
- Vérifiez la console pour les erreurs JavaScript

## 📱 Compatibilité

Le système d'animations est compatible avec :
- ✅ Chrome/Edge (dernières versions)
- ✅ Firefox (dernières versions)
- ✅ Safari (dernières versions)
- ✅ Appareils mobiles (iOS/Android)

## 🎓 Conseils de design

1. **Cohérence** : Utilisez les mêmes animations pour des éléments similaires
2. **Subtilité** : Moins c'est souvent mieux - ne surchargez pas la page
3. **Performance** : Testez sur mobile pour assurer la fluidité
4. **Accessibilité** : Certains utilisateurs préfèrent réduire les animations

## 📞 Support

Pour toute question ou problème, consultez la documentation complète dans `/docs/` ou contactez l'équipe de développement.

---

**Créé pour TRANSPORT ** - Version 1.0
