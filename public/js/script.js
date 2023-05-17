let burger = document.querySelector(".burger");
let menu = document.querySelector(".navLinks");
let carousel = document.querySelector(".your-class");
let fleche = document.querySelector(".fleche");
const images = document.querySelectorAll('.lightbox-image');

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
  carousel.classList.toggle('dNone')
  fleche.classList.toggle('dNone')

}


  images.forEach(image => {
    image.addEventListener('click', () => {
      // Créez un élément <div> pour afficher l'image en grand
      const lightbox = document.createElement('div');
      lightbox.classList.add('lightbox');

      // Créez un élément <img> pour afficher l'image en grand
      const fullSizeImage = document.createElement('img');
      fullSizeImage.src = image.src;
      fullSizeImage.alt = image.alt;

      // Ajoutez l'élément <img> à la lightbox
      lightbox.appendChild(fullSizeImage);

      // Ajoutez la lightbox à la page
      document.body.appendChild(lightbox);

      // Gérez la fermeture de la lightbox lors d'un clic à l'extérieur de l'image
      lightbox.addEventListener('click', () => {
        lightbox.remove();
    });
  });
});

