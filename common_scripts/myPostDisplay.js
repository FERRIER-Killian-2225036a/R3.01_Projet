const divButtonRole = document.getElementById('divButtonRole');
divButtonRole.style.display = "inherit";

divButtonRole.addEventListener("click", function() {
    window.location.href = "<?php echo $mapView['blogPostEditUrl'] ?>";
});
const blogTitle = document.getElementById('responsive-title');
const noBlogMessage = document.getElementById('noBlogMessage');

noBlogMessage.style.display = "none";
if (blogTitle === null) {
    divButtonRole.style.setProperty("display", "none", "important");
    noBlogMessage.style.display = "flex";
}