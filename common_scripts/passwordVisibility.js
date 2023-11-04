document.getElementById('passwordToggle').addEventListener('click', function() {
    const passwordInput = document.getElementById('form2Example22');
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordHide = document.getElementById('passwordHide');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.style.display = 'none';
        passwordHide.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        passwordToggle.style.display = 'block';
        passwordHide.style.display = 'none';
    }
});

document.getElementById('passwordHide').addEventListener('click', function() {
    const passwordInput = document.getElementById('form2Example22');
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordHide = document.getElementById('passwordHide');

    if (passwordInput.type === 'text') {
        passwordInput.type = 'password';
        passwordToggle.style.display = 'block';
        passwordHide.style.display = 'none';
    }
});
