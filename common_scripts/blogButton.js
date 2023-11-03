document.getElementById("divButtonRole").addEventListener("click", function() {
    const isInput = event.target.closest('.input-group');
    const isCustomInput = event.target.classList.contains('custom-input');

    if (!isInput && !isCustomInput) {
        window.location.href = "<?php echo $mapView['blogPostUrl'] ?>";
    }
});
