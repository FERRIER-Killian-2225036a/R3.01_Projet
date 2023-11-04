// Fonction pour la redirection quand on clique sur un blog dans le blogFeed avec l'exception pour l'input
function redirect(stringOfPostId) {
    // Sélection de tous les éléments avec l'ID "divButtonRole"
    const divButtonRoles = document.querySelectorAll('.button-role');
    // Séparation des éléments de stringOfPostId au niveau des virgules pour les entrer dans un tableau
    const listOfPostId = stringOfPostId.split(',');
    // Boucle parcourant tous les éléments de divButtonRoles
    for(let i=0; i<divButtonRoles.length; i++) {
        // Ajout d'un EventListener pour l'action du clique sur un élément de divButtonRoles
        divButtonRoles[i].addEventListener("click", function(event) {
            // Récupération de l'élément dont on ne veut pas que l'event listener est effet
            const isInput = event.target.closest('.exceptionButton-role');
            // Si on clique ailleurs que le bouton dont on ne veut pas:
            if (!isInput) {
                // Redirection vers la page correspondent au blog cliqué
                window.location.href = "https://cyphub.tech/Post/Blog/" + listOfPostId[i];
            }
        });
    }
}