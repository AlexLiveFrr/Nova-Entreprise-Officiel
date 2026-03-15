# 📱 Menu Responsive - Guide d'utilisation

## ✅ Ce qui a été fait

### 1. **CSS Responsive amélioré** (`assets/css/style.css`)
- Menu burger avec animation fluide (transformation en X)
- Menu mobile qui s'ouvre en douceur avec animation
- Fermeture automatique lors du clic sur un lien
- Fermeture lors du clic en dehors du menu
- Responsive parfait sur tous les écrans

### 2. **JavaScript centralisé** (`assets/js/menu.js`)
- Gestion complète du menu burger
- Fermeture automatique intelligente
- Gestion du redimensionnement de fenêtre
- Code réutilisable sur toutes les pages

### 3. **Pages mises à jour**
- ✅ `index.html` - Menu fonctionnel
- ✅ `contact.html` - Menu fonctionnel

## 🎯 Comment utiliser le menu sur vos pages

### Structure HTML à copier dans chaque page :

```html
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Titre | TRANSPORT </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="logo.png">
</head>

<body>
    <nav class="bg-slate-900 p-4 sticky top-0 z-50 shadow-xl border-b border-blue-600">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.html" class="flex items-center space-x-3">
                <img src="logo.png" alt="Logo Transport " class="h-10 md:h-12 w-auto">
                <span class="text-white text-xl font-black italic uppercase">TRANSPORT<span class="text-yellow-400"> </span></span>
            </a>
            
            <!-- Bouton Menu Burger (mobile) -->
            <div class="menu-toggle" id="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <!-- Liens de navigation -->
            <ul class="flex items-center gap-6 text-white text-xs font-bold uppercase tracking-widest" id="nav-links">
                <li><a href="index.html" class="hover:text-yellow-400 transition">Accueil</a></li>
                <li><a href="entreprise.html" class="hover:text-yellow-400 transition">Entreprise</a></li>
                <li><a href="convois.html" class="hover:text-yellow-400 transition">Convois</a></li>
                <li><a href="proposition-convoi.html" class="hover:text-yellow-400 transition">Proposer Convoi</a></li>
                <li><a href="pourquoinouschoisir.html" class="hover:text-yellow-400 transition">Pourquoi nous choisir ?</a></li>
                <li><a href="reglement.html" class="hover:text-yellow-400 transition">Règlement</a></li>
                
                <li><a href="partenaires.html" class="hover:text-yellow-400 transition">Partenaires</a></li>
                <li><a href="contact.html" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 transition">Postuler</a></li>
            </ul>
        </div>
    </nav>

    <!-- Votre contenu ici -->

    <!-- Script du menu (à mettre avant la fermeture du </body>) -->
    <script src="assets/js/menu.js"></script>
</body>
```

## 📱 Comportement du menu

### Sur Desktop (> 768px)
- Menu horizontal classique
- Tous les liens visibles
- Bouton burger caché

### Sur Mobile (≤ 768px)
- Bouton burger visible (3 barres)
- Menu caché par défaut
- Au clic sur le burger :
  - Menu s'ouvre avec animation
  - Burger se transforme en X
- Le menu se ferme :
  - Au clic sur un lien
  - Au clic en dehors du menu
  - Lors du passage en mode desktop

## 🎨 Personnalisation

### Modifier les couleurs
Éditez `assets/css/style.css` :

```css
:root {
    --bg-color: #0f172a;          /* Fond principal */
    --text-color: #f1f5f9;        /* Texte */
    --primary-yellow: #e8da92;    /* Jaune  */
    --primary-blue: #2563eb;      /* Bleu  */
}
```

### Modifier l'animation du menu
Dans `assets/css/style.css`, section `@keyframes slideDown`

## 🔧 Dépannage

### Le menu ne s'ouvre pas ?
1. Vérifiez que `assets/js/menu.js` est bien chargé
2. Vérifiez que les IDs sont corrects : `mobile-menu` et `nav-links`
3. Ouvrez la console du navigateur (F12) pour voir les erreurs

### Le menu ne se ferme pas ?
- Vérifiez que le JavaScript est chargé après le HTML
- Assurez-vous que `DOMContentLoaded` est bien écouté

### Le style ne s'applique pas ?
- Vérifiez le chemin vers `assets/css/style.css`
- Videz le cache du navigateur (Ctrl + F5)

## 📝 Pages à mettre à jour

Copiez la structure de navigation dans ces pages :
- [ ] entreprise.html
- [ ] convois.html
- [ ] proposition-convoi.html
- [ ] pourquoinouschoisir.html
- [ ] reglement.html
- [ ] flotte.html
- [ ] partenaires.html
- [ ] formulaire-partenaire.html

## 🚀 Améliorations futures possibles

1. **Sous-menus** : Ajouter des menus déroulants
2. **Indicateur de page active** : Mettre en surbrillance la page actuelle
3. **Animation plus complexe** : Effet slide depuis le côté
4. **Mode sombre/clair** : Toggle pour changer le thème

---

**Créé le** : 08/02/2026  
**Version** : 1.0  
**Auteur** : Assistant IA
