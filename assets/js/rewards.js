/* ========================================
   SYSTÈME DE RÉCOMPENSES NOVA ENTREPRISE OFFICIEL
   ======================================== */

// Configuration des récompenses
const REWARDS_CONFIG = {
    badges: [
        {
            id: 'rookie',
            name: 'Recrue',
            icon: '🚌',
            description: 'Bienvenue dans l\'équipe !',
            requirement: 'Rejoindre ',
            color: 'from-gray-500 to-gray-700'
        },
        {
            id: 'veteran',
            name: 'Vétéran',
            icon: '⭐',
            description: 'Plus de 100 services',
            requirement: '100+ services',
            color: 'from-blue-500 to-blue-700'
        },
        {
            id: 'expert',
            name: 'Expert',
            icon: '🏆',
            description: 'Plus de 500 services',
            requirement: '500+ services',
            color: 'from-purple-500 to-purple-700'
        },
        {
            id: 'legend',
            name: 'Légende',
            icon: '👑',
            description: 'Plus de 1000 services',
            requirement: '1000+ services',
            color: 'from-yellow-400 to-yellow-600'
        },
        {
            id: 'convoy_master',
            name: 'Maître des Services',
            icon: '🚦',
            description: 'Participation à 50+ services',
            requirement: '50+ services',
            color: 'from-green-500 to-green-700'
        },
        {
            id: 'safe_driver',
            name: 'Conducteur Prudent',
            icon: '🛡️',
            description: 'Aucun accident en 100 services',
            requirement: '0 accident / 100 services',
            color: 'from-cyan-500 to-cyan-700'
        },
        {
            id: 'speed_demon',
            name: 'Démon de la Vitesse',
            icon: '⚡',
            description: 'Service le plus rapide',
            requirement: 'Record de vitesse',
            color: 'from-red-500 to-red-700'
        },
        {
            id: 'night_owl',
            name: 'Hibou de Nuit',
            icon: '🌙',
            description: '100 services nocturnes',
            requirement: '100 services de nuit',
            color: 'from-indigo-500 to-indigo-700'
        },
        {
            id: 'long_haul',
            name: 'Longue Distance',
            icon: '🌍',
            description: 'Plus de 100 000 km parcourus',
            requirement: '100 000+ km',
            color: 'from-teal-500 to-teal-700'
        },
        {
            id: 'team_player',
            name: 'Esprit d\'Équipe',
            icon: '🤝',
            description: 'Aide 50+ membres',
            requirement: '50+ aides',
            color: 'from-pink-500 to-pink-700'
        }
    ],
    ranks: [
        { level: 1, name: 'Apprenti', minDeliveries: 0, icon: '🔰' },
        { level: 2, name: 'Conducteur', minDeliveries: 50, icon: '🚌' },
        { level: 3, name: 'Conducteur Confirmé', minDeliveries: 150, icon: '🚍' },
        { level: 4, name: 'Expert Exploitation', minDeliveries: 300, icon: '⭐' },
        { level: 5, name: 'Capitaine de Ligne', minDeliveries: 500, icon: '🏆' },
        { level: 6, name: 'Légende ', minDeliveries: 1000, icon: '👑' }
    ]
};

// Fonction pour afficher les badges
function displayRewardsBadges(containerId = 'rewards-container') {
    const container = document.getElementById(containerId);
    if (!container) return;

    const badgesHTML = REWARDS_CONFIG.badges.map((badge, index) => `
        <div class="card-animated hover-lift bg-slate-800 p-6 rounded-xl border border-slate-700 text-center delay-${index * 100}">
            <div class="reward-badge mx-auto mb-4 bg-gradient-to-br ${badge.color}">
                <span class="reward-badge-icon">${badge.icon}</span>
            </div>
            <h3 class="text-xl font-bold text-yellow-400 mb-2">${badge.name}</h3>
            <p class="text-gray-300 text-sm mb-3">${badge.description}</p>
            <div class="bg-slate-900 px-3 py-1 rounded-full inline-block">
                <span class="text-xs text-blue-400 font-semibold">${badge.requirement}</span>
            </div>
        </div>
    `).join('');

    container.innerHTML = badgesHTML;
    
    // Animation au scroll
    observeElements();
}

// Fonction pour afficher les rangs
function displayRanks(containerId = 'ranks-container') {
    const container = document.getElementById(containerId);
    if (!container) return;

    const ranksHTML = REWARDS_CONFIG.ranks.map((rank, index) => `
        <div class="card-animated hover-scale bg-slate-800 p-6 rounded-xl border-l-4 border-blue-600 flex items-center gap-4 delay-${index * 100}">
            <div class="text-5xl animate-pulse">${rank.icon}</div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-yellow-400 mb-1">${rank.name}</h3>
                <p class="text-gray-400 text-sm">Niveau ${rank.level}</p>
                <div class="mt-2 bg-slate-900 rounded-full h-2 overflow-hidden">
                    <div class="progress-bar bg-gradient-to-r from-blue-500 to-purple-500 h-full" style="width: ${(rank.minDeliveries / 1000) * 100}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">${rank.minDeliveries}+ services requis</p>
            </div>
        </div>
    `).join('');

    container.innerHTML = ranksHTML;
    
    // Animation au scroll
    observeElements();
}

// Observer pour animer les éléments au scroll
function observeElements() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.card-animated').forEach(el => {
        observer.observe(el);
    });
}

// Compteur animé
function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = Math.floor(target);
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Initialiser les compteurs animés
function initCounters() {
    document.querySelectorAll('[data-counter]').forEach(el => {
        const target = parseInt(el.getAttribute('data-counter'));
        animateCounter(el, target);
    });
}

// Animation des cartes au scroll
function initScrollAnimations() {
    const cards = document.querySelectorAll('.hover-lift, .hover-scale, .hover-glow');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, {
        threshold: 0.1
    });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
}

// Notification de récompense
function showRewardNotification(badge) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-20 right-4 bg-slate-800 border-2 border-yellow-400 rounded-xl p-4 shadow-2xl z-50 animate-fade-in-right';
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="text-4xl animate-bounce">${badge.icon}</div>
            <div>
                <h4 class="text-yellow-400 font-bold">Nouveau Badge !</h4>
                <p class="text-white text-sm">${badge.name}</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'fadeInRight 0.5s ease reverse';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Effet de particules
function createParticles(container, count = 20) {
    for (let i = 0; i < count; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.cssText = `
            position: absolute;
            width: 4px;
            height: 4px;
            background: ${['#3b82f6', '#8b5cf6', '#fbbf24'][Math.floor(Math.random() * 3)]};
            border-radius: 50%;
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            animation-delay: ${Math.random() * 3}s;
            opacity: ${Math.random() * 0.5 + 0.3};
        `;
        container.appendChild(particle);
    }
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser les animations de scroll
    initScrollAnimations();
    
    // Initialiser les compteurs
    initCounters();
    
    // Observer les éléments pour les animations
    observeElements();
    
    // Ajouter des classes d'animation aux éléments existants
    document.querySelectorAll('section > div > div').forEach((el, index) => {
        if (!el.classList.contains('animate-fade-in-up')) {
            el.classList.add('animate-fade-in-up');
            el.style.animationDelay = `${index * 0.1}s`;
        }
    });
});

// Exporter les fonctions pour utilisation globale
window.Rewards = {
    displayRewardsBadges,
    displayRanks,
    showRewardNotification,
    createParticles,
    animateCounter,
    REWARDS_CONFIG
};
