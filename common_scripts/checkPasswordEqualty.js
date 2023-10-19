function checkPasswordsEquality() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password === confirmPassword) {
        document.getElementById('message').textContent = "Les mots de passe correspondent !";
        document.getElementById('message').style.color = "green";
    } else {
        document.getElementById('message').textContent = "Les mots de passe ne correspondent pas !";
        document.getElementById('message').style.color = "red";
    }
}