/*document.getElementById("divButtonRole").addEventListener("click", function() {
    const isInput = event.target.closest('.input-group');
    if (!isInput) {
        window.location.href = "<?php echo $mapView['blogPostUrl'] ?>"; //TODO changer php pcq le lien est que sur le premier
    }
});

// Sélectionnez tous les éléments avec l'ID "divButtonRole" (supposons qu'ils aient une classe "button-role" pour cette démonstration)
const divButtonRoles = document.querySelectorAll('.button-role');

// Parcourez chaque élément et ajoutez l'événement
divButtonRoles.forEach(function(divButtonRole) {
    divButtonRole.addEventListener("click", function(event) {
        const isInput = event.target.closest('.input-group');
        if (!isInput) {
            window.location.href = "<?php echo $mapView['blogPostUrl'] ?>";
        }
    });
});*/
console.log('le js est bien chargé')

function redirect(stringOfLikns) {
    // Sélectionnez tous les éléments avec l'ID "divButtonRole" (supposons qu'ils aient une classe "button-role" pour cette démonstration)
    const divButtonRoles = document.querySelectorAll('.button-role');
    console.log(divButtonRoles);
    const listOfLikns = stringOfLikns.split(',');
    // Parcourez chaque élément et ajoutez l'événement
    for(let i=0; i<divButtonRoles.length; i++) {
        divButtonRoles[i].addEventListener("click", function(event) {
            console.log('Appui sur bouton' + divButtonRoles[i]);
            /*const isInput = event.target.closest('.input-group');
            if (!isInput) {
                window.location.href = listOfLikns[i];
            }*/
        });
    }
}


function bookmark(listOfBooleen) {
    /*try {
        let boolIsPostBookmarked = 0;
        let svgBookmarkAdd;
        let svgBookmarkDel;
    } catch {}
    // Récupération du booleen pour savoir si le post est enregistré ou pas
    boolIsPostBookmarked = "<?php echo $mapView['BoolIsPostBookmarked'] ? 1 : 0 ?>";
    // Sélection du signet d'ajout
    svgBookmarkAdd = document.getElementById('svgBookmarkAdd');
    // Sélection du signet de suppression
    svgBookmarkDel = document.getElementById('svgBookmarkDel');
    // Condition si l'utilisateur a enregistré le post
    if (boolIsPostBookmarked === 1) {
        // On cache le signet d'ajout
        svgBookmarkAdd.style.display = 'none';
        // On affiche le signet de suppression
        svgBookmarkDel.style.display = 'flex';
    }*/
    const divButtonRoles = document.querySelectorAll('.button-role');
}