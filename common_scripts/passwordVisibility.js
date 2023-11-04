document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("form2Example22");
    const passwordToggle = document.getElementById("passwordToggle");

    if (passwordInput && passwordToggle) {
        passwordToggle.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    }
});
