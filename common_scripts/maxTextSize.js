maxTextLength = 260;
maxTitleLength = 35;
function maxTextSizeForContent() {
    let classTextResponsive = document.getElementsByClassName("responsive-text");
    let text = classTextResponsive[0].textContent;
    if (text.length > maxTextLength) {
        classTextResponsive[0].innerHTML = text.slice(0, maxTextLength) + " <b>See more...</b>";
    }
}

function maxTextSizeForTitle() {
    let classTitleResponsive = document.getElementsByClassName("responsiveTitle");
    let text = classTitleResponsive[0].textContent;
    if (text.length > maxTitleLength) {
        classTitleResponsive[0].innerHTML = text.slice(0, maxTitleLength) + "...";
    }
}

maxTextSizeForContent();
maxTextSizeForTitle();