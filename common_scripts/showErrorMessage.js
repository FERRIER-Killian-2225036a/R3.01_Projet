function ShowLoginErrorMessage(status) {
    const errorMessage = document.getElementById('wrongInfo');
    errorMessage.style.display = 'inherit';
    console.log(status);
    if (status!=="success") {
        console.log("Avant" + errorMessage.textContent);
        errorMessage.textContent = status;
        console.log("Après" + errorMessage.textContent);
        errorMessage.style.display = 'inherit';
    } else {
        errorMessage.style.display = 'none';
    }
}