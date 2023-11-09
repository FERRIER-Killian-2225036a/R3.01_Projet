// Au chargement de la page, configurez Cropper.js
let cropper;

document.getElementById('file').addEventListener('change', function() {
    const file = this.files[0];
    const image = document.getElementById('image');

    if (file && image) {
        const reader = new FileReader();

        reader.onload = function(e) {
            image.src = e.target.result;
            document.getElementById('cropButton').style.display = 'block';

            // Initialisez Cropper.js avec l'image
            cropper = new Cropper(image, {
                aspectRatio: 1, // Ratio carré
                viewMode: 1,    // Ajuste l'image dans le cadre
            });
        };

        reader.readAsDataURL(file);
    }
});

document.getElementById('cropButton').addEventListener('click', function() {
    const croppedCanvas = cropper.getCroppedCanvas();

    if (croppedCanvas) {
        const croppedImage = document.getElementById('croppedImage');
        croppedImage.src = croppedCanvas.toDataURL();
        document.getElementById('confirmButton').style.display = 'block';
    }
});

document.getElementById('confirmButton').addEventListener('click', function() {
    // Récupérer l'image recadrée et effectuer une action, par exemple, l'envoyer au serveur.
    // ...
});
