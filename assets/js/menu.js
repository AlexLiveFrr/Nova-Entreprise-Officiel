// --- GESTION DU MENU BURGER (Navigation Mobile) ---
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');
    
    if(mobileMenu && navLinks) {
        // Toggle du menu au clic sur le burger
        mobileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            mobileMenu.classList.toggle('open');
        });

        // Fermer le menu quand on clique sur un lien
        const menuLinks = navLinks.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                mobileMenu.classList.remove('open');
            });
        });

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = navLinks.contains(event.target);
            const isClickOnToggle = mobileMenu.contains(event.target);
            
            if (!isClickInsideMenu && !isClickOnToggle && navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                mobileMenu.classList.remove('open');
            }
        });

        // Fermer le menu lors du redimensionnement de la fenêtre (passage desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navLinks.classList.remove('active');
                mobileMenu.classList.remove('open');
            }
        });
    }
});
