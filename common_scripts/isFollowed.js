// Script pour le changement du bouton suivre
function isFollowed(listOfBooleen) {
    // Sélection des boutons suivre
    const followedButton = document.querySelectorAll('.followButton');
    for (let i = 0; i < listOfBooleen.length; i++) {
        // Condition si l'utilisateur est suivi
        if (listOfBooleen[i] === '1') {
            // On change le texte du bouton
            followedButton[i+1].innerHTML = 'Suivi';
            // On met le fond en violet
            followedButton[i+1].style.backgroundColor = 'var(--purple)';
            // On met le texte en blanc
            followedButton[i+1].style.color = 'white';
        }
    }
}