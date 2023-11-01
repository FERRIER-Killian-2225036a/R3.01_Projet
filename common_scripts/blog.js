// Lorsque le bouton est cliqué
document.querySelector('label[for="file"]').addEventListener('click', function () {
    // Clique sur l'input de fichier caché pour permettre à l'utilisateur de choisir un fichier
    document.getElementById('file').click();
});


