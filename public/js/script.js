let burger = document.querySelector(".burger");
let menu = document.querySelector(".navLinks");

$(document).ready(function() {
    $('.your-class').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 400,
        fade: true,
        cssEase: 'linear'
    });
});

burger.addEventListener('click',open)
function open (){
  menu.classList.toggle('open')
}
