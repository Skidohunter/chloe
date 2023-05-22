let burger = document.querySelector(".burger");
let menu = document.querySelector(".navLinks");
let carousel = document.querySelector(".your-class");
let fleche = document.querySelector(".fleche");
const images = document.querySelectorAll('.lightbox-image');
let commentaireDash = document.getElementById('commentaireDash');
let allDash = document.getElementById('allDash')
let userDash = document.getElementById('userDash');
let contactDash = document.getElementById('contactDash');
let tableCom = document.getElementById('tableCom');
let tableUser = document.getElementById('tableUser');
let tableContact = document.getElementById('tableContact');

//Carousel//

$(document).ready(function() {
    $('.your-class').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 800,
        fade: true,
        cssEase: 'linear'
    });
});

//Menu Burger//

burger.addEventListener('click',open)
function open (){
  menu.classList.toggle('open')
  carousel.classList.toggle('dNone')
  fleche.classList.toggle('dNone')

}

//Galerie Images//

  images.forEach(image => {
    image.addEventListener('click', () => {
      const lightbox = document.createElement('div');
      lightbox.classList.add('lightbox');

      const fullSizeImage = document.createElement('img');
      fullSizeImage.src = image.src;
      fullSizeImage.alt = image.alt;


      lightbox.appendChild(fullSizeImage);


      document.body.appendChild(lightbox);

      lightbox.addEventListener('click', () => {
        lightbox.remove();
    });
  });
});

//DisplayNone Admin//

function displayNoneAll(){
  tableCom.classList.remove('dNone');
  tableUser.classList.remove('dNone');
  tableContact.classList.remove('dNone')
}

function displayNoneCom() {
  tableCom.classList.remove('dNone');
  tableUser.classList.add('dNone');
  tableContact.classList.add('dNone')
}

function displayNoneUser() {
  tableCom.classList.add('dNone');
  tableUser.classList.remove('dNone');
  tableContact.classList.add('dNone')
}

function displayNoneContact() {
  tableCom.classList.add('dNone');
  tableUser.classList.add('dNone');
  tableContact.classList.remove('dNone')
}

window.addEventListener('load', function() {
  displayNoneAll();
});

commentaireDash.addEventListener('click',displayNoneCom);
userDash.addEventListener('click',displayNoneUser);
contactDash.addEventListener('click',displayNoneContact);
allDash.addEventListener('click',displayNoneAll)



