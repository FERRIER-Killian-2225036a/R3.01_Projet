// Au chargement de la page, configurez Cropper.js
let cropper;

document.getElementById('image').src = 'url_de_votre_image_a_recadrer.jpg';

document.getElementById('cropButton').addEventListener('click', function() {
    const image = document.getElementById('image');
    const canvas = document.getElementById('croppedImage');

    // Initialisez Cropper.js avec l'image
    cropper = new Cropper(image, {
        aspectRatio: 1, // Ratio carré
        viewMode: 1,    // Ajuste l'image dans le cadre
        crop: function(event) {
            const croppedCanvas = cropper.getCroppedCanvas();
            canvas.width = croppedCanvas.width;
            canvas.height = croppedCanvas.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(croppedCanvas, 0, 0, croppedCanvas.width, croppedCanvas.height);
        }
    });

    document.getElementById('confirmButton').style.display = 'block';
});

document.getElementById('confirmButton').addEventListener('click', function() {
    const croppedCanvas = cropper.getCroppedCanvas();

    if (croppedCanvas) {
        // Récupérer l'image recadrée et effectuer une action, par exemple, l'envoyer au serveur.
        const croppedImageURL = croppedCanvas.toDataURL('image/jpeg');
        // Vous pouvez maintenant faire quelque chose avec l'URL de l'image recadrée, par exemple, l'envoyer au serveur.
    }
});
