document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("form2Example22");
    const passwordToggle = document.getElementById("passwordToggle");
    const passwordToggleOff = document.getElementById("passwordToggleOff");

    passwordToggle.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordToggle.style.display = "none";
            passwordToggleOff.style.display = "block";
        } else {
            passwordField.type = "password";
            passwordToggle.style.display = "block";
            passwordToggleOff.style.display = "none";
        }
    });

    passwordToggleOff.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordToggleOff.style.display = "none";
            passwordToggle.style.display = "block";
        } else {
            passwordField.type = "password";
            passwordToggleOff.style.display = "block";
            passwordToggle.style.display = "none";
        }
    });
});
