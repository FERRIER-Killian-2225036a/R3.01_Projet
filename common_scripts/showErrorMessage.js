function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    errorMessage.style.display = 'none';
    if (status!=="success") {
        errorMessage.textContent = status;
        errorMessage.style.display = 'inherit';
    } else {
        errorMessage.style.display = 'none';
    }
}