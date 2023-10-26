function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    let errorMessageText = errorMessage[0].textContent;
    console.log(status, errorMessageText);
    if (status!=="success") {
        errorMessage.style.display = 'inherit';
    } else {
        errorMessage[0].innerHTML = status;
        errorMessage.style.display = 'none';
    }
}