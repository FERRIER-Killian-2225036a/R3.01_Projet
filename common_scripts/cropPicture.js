// Supposons que "inputFile" est l'élément <input> pour sélectionner l'image.
const inputFile = document.getElementById('inputFile');

inputFile.addEventListener('change', function() {
    const file = inputFile.files[0];
    const image = new Image();
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    image.onload = function() {
        const size = Math.min(image.width, image.height);
        canvas.width = size;
        canvas.height = size;
        ctx.drawImage(image, 0, 0, size, size, 0, 0, size, size);

        // Maintenant, "canvas" contient l'image carrée recadrée.
        const croppedImage = canvas.toDataURL('image/png');
    };

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
