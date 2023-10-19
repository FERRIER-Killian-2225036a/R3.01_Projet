// Récupérez le chemin de l'URL actuelle
const currentPath = window.location.pathname;

// Récupérez tous les éléments de navigation (liens)
const navLinks = document.querySelectorAll('.nav-link');

// Parcourez les liens
navLinks.forEach(link => {
    // Vérifiez si le chemin de l'URL correspond à l'attribut "href" du lien
    if (currentPath === link.getAttribute('href')) {
        // Ajoutez la classe "active" au lien si le chemin correspond
        link.classList.add('active');
    }
});
