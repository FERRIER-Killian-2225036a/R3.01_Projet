// Fonction pour vérifier la solidité du mot de passe
function checkPasswordStrength(password) {
    const progressBar = document.getElementById('password-strength-bar');
    const percentage = calculatePasswordStrength(password);

    // Pour que la barre prenne une taille définiz
    /*const maxWidth = 28; // Largeur maximale souhaitée en pixels
    const width = Math.min((percentage * maxWidth / 100), maxWidth) + 'vh';
    progressBar.style.width = width;*/

    // Pour que la barre prenne toute la largeur avec ( margin: 0 )
    progressBar.style.width = percentage + '%';

    // Ajout de classes CSS en fonction du niveau de solidité
    if (percentage < 40) {
        progressBar.className = 'password-weak';
    } else if (percentage < 70) {
        progressBar.className = 'password-medium';
    } else if (percentage < 80) {
        progressBar.className = 'password-strong';
    } else {
        progressBar.className = 'password-verystrong';
    }
}


// Fonction pour calculer la solidité du mot de passe
function calculatePasswordStrength(password) {
    // Initialiser un score de solidité
    let score = 0;

    // Vérifier la longueur du mot de passe
    if (password.length >= 9) {
        score++;
    }

    // Vérifier la présence de chiffres
    if (/[0-9]/.test(password)) {
        score++;
    }

    // Vérifier la présence de lettres majuscules
    if (/[A-Z]/.test(password)) {
        score++;
    }

    // Vérifier la présence de caractères spéciaux
    if (/[!@#$%^&*()_+{}\[\]:;<>,.?~\\]/.test(password)) {
        score++;
    }

    // La valeur maximale du score dépendra du nombre de critères vérifiés.
    // Par exemple, si vous avez 4 critères comme dans l'exemple ci-dessus, la valeur maximale serait 4.

    // Calculez la largeur de la barre en pourcentage en fonction du score
    const maxScore = 4; // Remplacez par le nombre total de critères
    const percentage = (score / maxScore) * 100;

    return percentage;
}

