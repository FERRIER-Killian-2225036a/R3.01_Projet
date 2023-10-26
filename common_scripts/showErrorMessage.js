function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    errorMessage.style.display = 'inherit';
    let errorMessageText = errorMessage[0].textContent;
    console.log(status, errorMessageText);
    if (status!=="success") {
        errorMessage.style.display = 'inherit';
    } else {
        errorMessageText.innerHTML = status;
        errorMessage.style.display = 'none';
    }
}