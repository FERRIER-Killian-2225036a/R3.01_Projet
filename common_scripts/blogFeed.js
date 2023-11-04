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

// Sélectionnez tous les éléments avec l'ID "divButtonRole" (supposons qu'ils aient une classe "button-role" pour cette démonstration)
const divButtonRoles = document.querySelectorAll('.button-role');

// Parcourez chaque élément et ajoutez l'événement
for(let i=0; i<divButtonRoles.length; i++) {
    divButtonRoles[i].addEventListener("click", function(event) {
        const isInput = event.target.closest('.input-group');
        if (!isInput) {
            window.location.href = "<?php echo $mapView['blogPostUrl'] ?>";
        }
    });
}