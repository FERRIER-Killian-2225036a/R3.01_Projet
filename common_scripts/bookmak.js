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