function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    let errorMessageText = errorMessage.textContent;
    console.log(status, errorMessageText);
    if (status!=="success") {
        errorMessage.style.display = 'inherit';
    } else {
        errorMessage.innerHTML = status;
        errorMessage.style.display = 'none';
    }
}