function maxTextSize() {
    let classTexteResponsive = document.getElementsByClassName("responsive-text");
    let text = classTexteResponsive[0].textContent;
    let textSize = text.length;
    let textBien = text.slice(0, 260) + " <b>See more...</b>";
    console.log(text, textSize, textBien);
    classTexteResponsive[0].innerHTML = textBien;

}

maxTextSize();