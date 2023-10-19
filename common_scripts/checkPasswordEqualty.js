function checkPasswordsEquality() {
    const passwordElement = document.getElementById('passwordStrength');
    const confirmPasswordElement = document.getElementById('confirmPassword');
    const feedbackElement = document.getElementById('passwordFeedback');

    const password = passwordElement.value;
    const confirmPassword = confirmPasswordElement.value;

    if (password && confirmPassword) {
        if (password === confirmPassword) {
            confirmPasswordElement.setCustomValidity('');
            feedbackElement.textContent = "Les mots de passe correspondent.";
            feedbackElement.style.color = "green";
            confirmPasswordElement.classList.add('valid');
            confirmPasswordElement.classList.remove('invalid');
        } else {
            confirmPasswordElement.setCustomValidity('Les mots de passe ne correspondent pas !');
            feedbackElement.textContent = "Les mots de passe ne correspondent pas.";
            feedbackElement.style.color = "red";
            confirmPasswordElement.classList.add('invalid');
            confirmPasswordElement.classList.remove('valid');
        }
    } else {
        confirmPasswordElement.setCustomValidity('');
        feedbackElement.textContent = "";
        confirmPasswordElement.classList.remove('valid');
        confirmPasswordElement.classList.remove('invalid');
    }
}