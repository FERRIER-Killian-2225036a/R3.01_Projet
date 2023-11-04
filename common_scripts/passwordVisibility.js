document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("passwordStrength");
    const toggleButton = document.getElementById("passwordToggle");
    const toggleButtonOff = document.getElementById("passwordToggleOff");

    toggleButton.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.style.display = "none";
            toggleButtonOff.style.display = "block";
        } else {
            passwordInput.type = "password";
            toggleButton.style.display = "block";
            toggleButtonOff.style.display = "none";
        }
    });

    toggleButtonOff.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.style.display = "none";
            toggleButtonOff.style.display = "block";
        } else {
            passwordInput.type = "password";
            toggleButton.style.display = "block";
            toggleButtonOff.style.display = "none";
        }
    });
});
