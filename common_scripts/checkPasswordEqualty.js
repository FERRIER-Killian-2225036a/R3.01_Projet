function checkPasswordsEquality() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password && confirmPassword) { // On vérifie si les deux champs ont des valeurs pour éviter un feedback inutile lorsque les champs sont vides
        if (password === confirmPassword) {
            document.getElementById('message').textContent = "Les mots de passe correspondent !";
            document.getElementById('message').style.color = "green";
        } else {
            document.getElementById('message').textContent = "Les mots de passe ne correspondent pas !";
            document.getElementById('message').style.color = "red";
        }
    } else {
        document.getElementById('message').textContent = ""; // Efface le message s'il n'y a pas de valeur dans l'un des champs
    }
}