// Fonction pour changer le style en fonction de la solidité du mot de passe
function checkPasswordStrength(password) {
    const passwordInput = document.getElementById('passwordStrength'); // Sélectionnez l'élément d'input par son ID
    const percentage = calculatePasswordStrength(password);

    // Ajout de classes CSS en fonction du niveau de solidité
    if (percentage < 40) {
        passwordInput.classList.remove('password-medium', 'password-strong', 'password-verystrong');
        passwordInput.classList.add('password-weak');
    } else if (percentage < 70) {
        passwordInput.classList.remove('password-weak', 'password-strong', 'password-verystrong');
        passwordInput.classList.add('password-medium');
    } else if (percentage < 80) {
        passwordInput.classList.remove('password-weak', 'password-medium', 'password-verystrong');
        passwordInput.classList.add('password-strong');
    } else {
        passwordInput.classList.remove('password-weak', 'password-medium', 'password-strong');
        passwordInput.classList.add('password-verystrong');
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

