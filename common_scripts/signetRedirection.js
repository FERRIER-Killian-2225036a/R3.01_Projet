// Sélection de tous les éléments avec la classe .formSignetClass
const elementsWithClass = document.querySelectorAll('.formSignetClass');
currentPath = window.location.pathname;
console.log("Redirection lancé vers https://cyphub.tech" + currentPath);
// Fonction pour gérer le clic sur ces éléments
function handleClick(event) {
    event.stopPropagation();
    // Redirection vers l'URL du blog
    window.location.href = "https://cyphub.tech" + currentPath;
}
// Ajout du gestionnaire d'événements à chaque élément
elementsWithClass.forEach((element) => {
    element.addEventListener('click', handleClick);
});