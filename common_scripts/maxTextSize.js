let maxTextLength = 220;
let maxTitleLength = 45;


let classTextResponsive = document.getElementsByClassName("responsive-text");
for (let i = 0; i < classTextResponsive.length; i++) {
    let text = classTextResponsive[i].textContent;
    if (text.length > maxTextLength) {
        classTextResponsive[i].innerHTML = text.slice(0, maxTextLength) + "... <b>See more...</b>";
    }
}

let classTitleResponsive = document.getElementsByClassName("responsive-title");
console.log(classTitleResponsive[0].textContent)
for (let i = 0; i < classTitleResponsive.length; i++) {
    let text = classTitleResponsive[i].textContent;
    if (text.length > maxTitleLength) {
        classTitleResponsive[i].innerHTML = text.slice(0, maxTitleLength) + "...";
    }
}
