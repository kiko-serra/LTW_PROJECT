const buttonLeft = document.querySelector('.scroll-left');
const buttonRight = document.querySelector('.scroll-right');

buttonRight.onclick = function () {
    document.querySelector('.scrolling-wrapper').scrollLeft += 350;
};

buttonLeft.onclick = function () {
    document.querySelector('.scrolling-wrapper').scrollLeft -= 350;
};