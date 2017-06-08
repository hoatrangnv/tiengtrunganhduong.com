setObjectOrientations();
function setObjectOrientations() {
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio.__16x9 .img-wrap *"), 16 / 9);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio.__5x3 .img-wrap *"), 5 / 3);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio.__3x1 .img-wrap *"), 3);
}