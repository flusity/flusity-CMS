$(window).scroll(function () {
    if ($(window).scrollTop() > 50) {
      $(".navbar").addClass("scrolled");
    } else {
      $(".navbar").removeClass("scrolled");
    }
  });

  document.querySelector('.navbar-toggler').addEventListener('click', function() {
    var navbarCollapse = document.querySelector('.navbar-collapse');

    if (!navbarCollapse.classList.contains('show')) {
        navbarCollapse.style.backgroundColor = '#ffffff'; 
    } else {
        navbarCollapse.style.backgroundColor = 'transparent';
    }
});

var opacity = 0.382; 
var direction = 1; 

setInterval(function() {
    opacity += direction * 0.001; 

    if (opacity >= 0.5) {
        direction = -1;
    } else if (opacity <= 0.1) {
        direction = 1;
    }

    document.querySelector('.header .overlay').style.backgroundColor = 'rgba(27, 31, 35, ' + opacity + ')';

}, 20); 

var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var mouseX = window.innerWidth / 2; 
var mouseY = window.innerHeight / 2; 

function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
resizeCanvas();
window.onresize = resizeCanvas;


window.addEventListener('load', (event) => {
  let words = Array.from(document.querySelectorAll('.word'));
  words.forEach((word, index) => {
    word.style.animation = 'fade-in-right 0.5s forwards';
    word.style.animationDelay = `${index * 0.5}s`;
  });
});

window.addEventListener('load', (event) => {
  let easywords = Array.from(document.querySelectorAll('.easy-word'));
  easywords.forEach((easywords, index) => {
    easywords.style.animation = 'fade-in-right 0.5s forwards';
    easywords.style.animationDelay = `${index * 0.5}s`;
  });
});
