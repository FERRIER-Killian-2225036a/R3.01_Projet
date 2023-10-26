function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    let errorMessageText = errorMessage.textContent;
    console.log(errorMessageText);
    if (status!=="success") {
        errorMessage.style.display = 'inherit';
    } else {
        errorMessageText.innerHTML = status;
        errorMessage.style.display = 'none';
    }
}