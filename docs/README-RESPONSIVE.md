# 🚛 TRANSPORT  - Site Web Responsive

## 📱 Menu Responsive - Résumé des modifications

### ✅ Fichiers modifiés/créés

#### 1. **CSS Principal** (`assets/css/style.css`)
- ✅ Menu burger avec animation fluide
- ✅ Transformation du burger en X lors de l'ouverture
- ✅ Menu mobile avec animation slideDown
- ✅ Responsive containers pour tous les écrans
- ✅ Breakpoints optimisés (mobile: ≤768px, desktop: >768px)

#### 2. **JavaScript Menu** (`assets/js/menu.js`) - **NOUVEAU**
- ✅ Gestion complète du menu burger
- ✅ Toggle d'ouverture/fermeture
- ✅ Fermeture automatique au clic sur un lien
- ✅ Fermeture au clic en dehors du menu
- ✅ Gestion du redimensionnement de fenêtre
- ✅ Code réutilisable sur toutes les pages

#### 3. **Pages HTML mises à jour**
- ✅ `index.html` - Menu fonctionnel + intégration CSS externe
- ✅ `contact.html` - Menu fonctionnel + script séparé
- ✅ `test-menu.html` - **NOUVEAU** - Page de test complète

#### 4. **Documentation**
- ✅ `docs/MENU-RESPONSIVE.md` - Guide complet d'utilisation
- ✅ `README-RESPONSIVE.md` - Ce fichier (résumé)

---

## 🎯 Fonctionnalités du menu

### Sur Desktop (largeur > 768px)
- 🖥️ Menu horizontal classique
- 📋 Tous les liens visibles en ligne
- 🚫 Bouton burger caché
- ✨ Effet hover sur les liens

### Sur Mobile (largeur ≤ 768px)
- 📱 Bouton burger visible (3 barres horizontales)
- 🔒 Menu caché par défaut
- 👆 Clic sur burger = ouverture avec animation
- ❌ Burger se transforme en X
- 🔗 Clic sur un lien = fermeture automatique
- 🖱️ Clic en dehors = fermeture automatique
- 📐 Menu en colonne, centré, avec espacement

---

## 🚀 Comment tester

### Option 1 : Page de test dédiée
1. Ouvrez `test-menu.html` dans votre navigateur
2. Suivez les instructions sur la page
3. Redimensionnez la fenêtre pour voir le comportement responsive

### Option 2 : Test avec les outils de développement
1. Ouvrez n'importe quelle page (index.html, contact.html)
2. Appuyez sur `F12` pour ouvrir les outils de développement
3. Cliquez sur l'icône de responsive design (ou `Ctrl+Shift+M`)
4. Testez différentes tailles d'écran :
   - iPhone SE (375px)
   - iPhone 12 Pro (390px)
   - iPad (768px)
   - Desktop (1920px)

### Option 3 : Test sur appareil réel
1. Accédez au site depuis votre smartphone
2. Vérifiez que le burger apparaît
3. Testez l'ouverture/fermeture du menu

---

## 📋 Structure HTML à utiliser

Pour ajouter le menu responsive sur une nouvelle page :

```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Page | TRANSPORT </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="logo.png">
</head>

<body>
    <!-- Navigation -->
    <nav class="bg-slate-900 p-4 sticky top-0 z-50 shadow-xl border-b border-blue-600">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.html" class="flex items-center space-x-3">
                <img src="logo.png" alt="Logo Transport " class="h-10 md:h-12 w-auto">
                <span class="text-white text-xl font-black italic uppercase">
                    TRANSPORT<span class="text-yellow-400"> </span>
                </span>
            </a>
            
            <!-- Bouton Menu Burger -->
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
    <main>
        <!-- ... -->
    </main>

    <!-- Script du menu (IMPORTANT : à la fin du body) -->
    <script src="assets/js/menu.js"></script>
</body>
</html>
```

---

## 🎨 Personnalisation des couleurs

Les couleurs sont définies dans `assets/css/style.css` :

```css
:root {
    --bg-color: #0f172a;          /* Fond principal (bleu foncé) */
    --text-color: #f1f5f9;        /* Texte (blanc cassé) */
    --card-bg: #1e293b;           /* Fond des cartes */
    --input-bg: #ffffff;          /* Fond des champs de formulaire */
    --primary-yellow: #e8da92;    /* Jaune  */
    --primary-blue: #2563eb;      /* Bleu  */
}
```

---

## 🔧 Pages restantes à mettre à jour

Copiez la structure de navigation dans ces pages :

- [ ] `entreprise.html`
- [ ] `convois.html`
- [ ] `proposition-convoi.html`
- [ ] `pourquoinouschoisir.html`
- [ ] `reglement.html`
- [ ] `flotte.html`
- [ ] `partenaires.html`
- [ ] `formulaire-partenaire.html`

**Étapes pour chaque page :**
1. Remplacer la balise `<nav>` par la nouvelle structure
2. Ajouter `<link rel="stylesheet" href="assets/css/style.css">` dans le `<head>`
3. Ajouter `<script src="assets/js/menu.js"></script>` avant `</body>`
4. Tester sur mobile et desktop

---

## 📊 Breakpoints utilisés

| Taille d'écran | Largeur | Comportement |
|----------------|---------|--------------|
| Mobile         | ≤ 768px | Menu burger visible, menu vertical caché |
| Tablet         | 769px - 1023px | Menu horizontal visible |
| Desktop        | ≥ 1024px | Menu horizontal complet |

---

## ✅ Checklist de test

Avant de valider, vérifiez que :

- [ ] Le menu burger apparaît sur mobile (≤768px)
- [ ] Le menu s'ouvre au clic sur le burger
- [ ] Le burger se transforme en X quand le menu est ouvert
- [ ] Le menu se ferme au clic sur un lien
- [ ] Le menu se ferme au clic en dehors
- [ ] Le menu redevient horizontal sur desktop (>768px)
- [ ] Le menu reste en haut lors du scroll (sticky)
- [ ] Les liens changent de couleur au survol
- [ ] Le bouton "Postuler" a un fond bleu
- [ ] Le logo est visible et cliquable

---

## 🐛 Dépannage

### Le menu ne s'ouvre pas
1. Vérifiez que `assets/js/menu.js` est bien chargé
2. Ouvrez la console (F12) et cherchez les erreurs JavaScript
3. Vérifiez que les IDs sont corrects : `mobile-menu` et `nav-links`

### Le style ne s'applique pas
1. Vérifiez le chemin vers `assets/css/style.css`
2. Videz le cache du navigateur (Ctrl + F5)
3. Vérifiez qu'il n'y a pas de CSS inline qui écrase les styles

### Le burger ne se transforme pas en X
1. Vérifiez que la classe `.open` est bien ajoutée au burger
2. Vérifiez que le CSS pour `.menu-toggle.open span` est présent

---

## 📞 Support

Pour toute question ou problème :
1. Consultez `docs/MENU-RESPONSIVE.md` pour plus de détails
2. Testez avec `test-menu.html`
3. Vérifiez la console du navigateur (F12)

---

**Version** : 1.0  
**Date** : 08/02/2026  
**Testé sur** : Chrome, Firefox, Safari, Edge  
**Compatible** : Tous les appareils (mobile, tablette, desktop)
