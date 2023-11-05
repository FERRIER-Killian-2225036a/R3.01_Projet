// Script pour le changement du bouton suivre
function isFollowed(listOfBooleen) {
    // Sélection du bouton suivre
    /*const followedButton = document.getElementsByClassName('followButton');
    // Récupération du boolen pour savoir si on suit l'utilisateur qui a posté
    let boolIsFollowed = <?php echo $mapView['BoolIsFollowed'] ? 1 : 0 ?>; // TODO php mauvais user, a changer (author au lieu de user) pas sure a verif ?
    // Condition si l'utilisateur est suivi
    if (boolIsFollowed === 1) {
        for (let i = 0; i < followedButton.length; ++i) {
            // On change le texte du bouton
            followedButton[i].innerHTML = 'Suivi';
            // On met le fond en violet
            followedButton[i].style.backgroundColor = 'var(--purple)';
            // On met le texte en blanc
            followedButton[i].style.color = 'white';
        }
    }*/
    console.log(listOfBooleen);
    const followedButton = document.querySelectorAll('.followButton');
    console.log(followedButton);
    for (let i = 1; i < listOfBooleen.length; i++) {
        // Condition si l'article est enregistré
        console.log(listOfBooleen[i])
        if (listOfBooleen[i] === '1') {
            // On change le texte du bouton
            followedButton[i].innerHTML = 'Suivi';
            // On met le fond en violet
            followedButton[i].style.backgroundColor = 'var(--purple)';
            // On met le texte en blanc
            followedButton[i].style.color = 'white';
        }
    }
}