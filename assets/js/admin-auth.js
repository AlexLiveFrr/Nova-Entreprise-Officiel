// ========================================
// PROTECTION DES PAGES ADMINISTRATION
// ========================================

// Vérifier l'authentification
function checkAuth() {
    if (sessionStorage.getItem('admin_logged_in') !== 'true') {
        window.location.href = '/login.html';
        return false;
    }
    return true;
}

// Fonction de déconnexion
function logout() {
    if (confirm('Voulez-vous vraiment vous déconnecter ?')) {
        sessionStorage.removeItem('admin_logged_in');
        sessionStorage.removeItem('admin_username');
        sessionStorage.removeItem('admin_login_time');
        window.location.href = '/login.html';
    }
}

// Obtenir le nom d'utilisateur
function getUsername() {
    return sessionStorage.getItem('admin_username') || 'Admin';
}

// Vérifier si la session est expirée (4 heures)
function checkSessionExpiry() {
    const loginTime = sessionStorage.getItem('admin_login_time');
    if (loginTime) {
        const now = new Date();
        const login = new Date(loginTime);
        const diff = (now - login) / 1000 / 60 / 60; // Différence en heures
        
        if (diff > 4) {
            alert('Votre session a expiré. Veuillez vous reconnecter.');
            sessionStorage.removeItem('admin_logged_in');
            sessionStorage.removeItem('admin_username');
            sessionStorage.removeItem('admin_login_time');
            window.location.href = '/login.html';
            return false;
        }
    }
    return true;
}

// Exécuter la vérification au chargement de la page
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        checkAuth();
        checkSessionExpiry();
    });
} else {
    checkAuth();
    checkSessionExpiry();
}

// Vérifier toutes les 5 minutes
setInterval(checkSessionExpiry, 5 * 60 * 1000);
