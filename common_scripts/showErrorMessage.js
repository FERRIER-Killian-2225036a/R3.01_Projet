function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    errorMessage.style.display = 'none';
    errorMessage.textContent = status;
    errorMessage.style.display = 'inherit';
}