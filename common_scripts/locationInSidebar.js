// Récupérez tous les éléments de navigation (liens)
const navLinksSidebar = document.querySelectorAll('.nav-link');

// Parcourez les liens
navLinksSidebar.forEach(link => {
    // Vérifiez si le chemin de l'URL correspond à l'attribut "href" du lien
    if (currentPath === link.getAttribute('href')) {
        // Ajoutez la classe "active" au lien si le chemin correspond
        link.classList.add('on');
    } else {
        // Supprimez la classe "active" du lien si le chemin ne correspond pas
        link.classList.remove('on');
    }
});