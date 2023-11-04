document.getElementById("divButtonRole").addEventListener("click", function() {
    const isInput = event.target.closest('.input-group');
    if (!isInput) {
        window.location.href = "<?php echo $mapView['blogPostUrl'] ?>"; //TODO changer php pcq le lien est que sur le premier
    }
});

