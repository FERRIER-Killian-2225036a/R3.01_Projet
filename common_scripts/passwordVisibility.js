// Function to toggle password visibility
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('form2Example22');
    const passwordIcon = document.getElementById('passwordToggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fas fa-eye';
    }
}

// Add an event listener to the password visibility toggle button
document.getElementById('passwordToggle').addEventListener('click', togglePasswordVisibility);
