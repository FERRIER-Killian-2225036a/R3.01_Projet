// Récupérez tous les éléments de navigation (liens)
const navLinks = document.querySelectorAll('.nav-link');

// Parcourez les liens et ajoutez un gestionnaire d'événements de clic
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        // Supprimez la classe "active" de tous les liens
        navLinks.forEach(navLink => {
            navLink.classList.remove('active');
        });

        // Ajoutez la classe "active" uniquement au lien sur lequel vous avez cliqué
        link.classList.add('active');
    });
});
