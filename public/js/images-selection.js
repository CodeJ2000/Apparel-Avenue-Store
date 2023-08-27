$(document).ready(function(){
    const mainImage = document.getElementById("MainImg");
    const smallImg = document.getElementsByClassName("small-img");

    smallImg[0].onclick = function () {
    mainImage.src = smallImg[0].src;
    };

    smallImg[1].onclick = function () {
    mainImage.src = smallImg[1].src;
    };

    smallImg[2].onclick = function () {
    mainImage.src = smallImg[2].src;
    };

    smallImg[3].onclick = function () {
    mainImage.src = smallImg[3].src;
    };
});