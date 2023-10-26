function ShowLoginErrorMessage(status) {
    console.log("Est-ce que ca marche ?");
    const errorMessage = document.getElementById('wrongInfo');
    if (status!=="success") {
        errorMessage.style.display = 'inherit';
    } else {
        errorMessage.innerHTML = status;
        errorMessage.style.display = 'none';
    }
}