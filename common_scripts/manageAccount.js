function updateImage() {
    // Ici, vous pouvez ajouter la logique pour mettre à jour l'image
    alert('Fonctionnalité pour modifier la photo de profil à implémenter.');
}

function deleteImage() {
    // Ici, vous pouvez ajouter la logique pour supprimer l'image
    alert('Fonctionnalité pour supprimer la photo de profil à implémenter.');
}

function updateUsername() {
    // Ici, vous pouvez ajouter la logique pour mettre à jour le pseudo
    alert('Fonctionnalité pour modifier le pseudo à implémenter.');
}
function updateEmail(){
    alert('Fonctionnalité pour modifier l\'email à implémenter');
}
function updatePassword(){
    alert('Fonctionnalité pour modifier le mot de passe à implémenter');
}
function deleteAccount(){
    alert('Fonctionnalité pour modifier supprimer le compte à implémenter');
}

// Lorsque le label "Modifier" est cliqué
document.querySelector('label[for="file"]').addEventListener('click', function () {
    // Clique sur l'input de fichier caché pour permettre à l'utilisateur de choisir un fichier
    document.getElementById('file').click();
});

// Lorsque le champ de fichier est modifié (un fichier est sélectionné)
document.getElementById('file').addEventListener('change', function () {
    // Soumet automatiquement le formulaire lorsque l'utilisateur sélectionne un fichier
    this.parentNode.submit(); // Cela enverra le formulaire avec le fichier sélectionné
});