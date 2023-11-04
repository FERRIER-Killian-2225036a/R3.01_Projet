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
            const isInput = event.target.closest('.input-group');
            // Si on clique ailleurs que le bouton dont on ne veut pas:
            if (!isInput) {
                // Redirection vers la page correspondent au blog cliqué
                window.location.href = "https://cyphub.tech/Post/Blog/" + listOfPostId[i];
            }
        });
    }
}

// Fonction pour chnager l'icone du signet d'enregistrement d'article
function bookmark(listOfBooleen) { // listOfBooleen est un tableau avec '1' si l'utilisateur a enregistré l'article et '0' pour l'inverse
    // Récupération du svg d'enregistrement
    const svgBookmarkAdd = document.querySelectorAll('#svgBookmarkAdd');
    // Récupération du svg de suppression
    const svgBookmarkDel = document.querySelectorAll('#svgBookmarkDel');
    // Boucle parcourant toute la string listOfBooleen
    for (let i = 0; i < listOfBooleen.length; i++) {
        // Condition si l'article est enregistré
        if (listOfBooleen[i] === '1') {
            // On cache le signet d'ajout
            svgBookmarkAdd[i].style.display = 'none';
            // On affiche le signet de suppression
            svgBookmarkDel[i].style.display = 'flex';
        }
    }
}