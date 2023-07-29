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

var opacity = 0.382; // pradinė reikšmė
var direction = 1; // 1 reiškia didėjimą, -1 reiškia mažėjimą

setInterval(function() {
    opacity += direction * 0.001; // keičiame permatomumo reikšmę

    // jei reikšmė pasiekia 0.5 arba 0.1, keičiame kryptį
    if (opacity >= 0.5) {
        direction = -1;
    } else if (opacity <= 0.1) {
        direction = 1;
    }

    // taikome naująją permatomumo reikšmę
    document.querySelector('.header .overlay').style.backgroundColor = 'rgba(27, 31, 35, ' + opacity + ')';

}, 20); // keičiame kas 20 milisekundes

var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var mouseX = window.innerWidth / 2; // pradinė pelės pozicija
var mouseY = window.innerHeight / 2; // pradinė pelės pozicija

// Resize canvas to full window size
function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
resizeCanvas();
window.onresize = resizeCanvas;

// Generate lines

var colors = ['rgba(0, 255, 0, 0.15)', 'rgba(0, 0, 255, 0.15)', 'rgba(255, 0, 0, 0.15)', 'rgba(255, 255, 0, 0.15)'];

// Generate lines
function generateLine(x, y) {
  var line = {
    x: x,
    y: y,
    length: Math.random() * 500 + 50,
    angle: Math.random() * 2 * Math.PI,
    speed: Math.random() * 2 + 1,
    opacity: Math.random() * 0.5 + 0.5,
    hasDot: Math.random() < 0.5, // 50% chance a line will have a dot
    dotColor: colors[Math.floor(Math.random() * colors.length)] // random color
  };
  return line;
}
var lines = [];
for (var i = 0; i < 10; i++) { // generate 10 lines
  lines.push(generateLine(mouseX, mouseY));
}

// Draw lines
function drawLines() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.strokeStyle = 'rgba(255, 255, 255, 0.5)'; // white lines with 50% opacity
  for (var i = 0; i < lines.length; i++) {
    var line = lines[i];
    ctx.beginPath();
    ctx.moveTo(line.x, line.y);
    ctx.lineTo(line.x + line.length * Math.cos(line.angle), line.y + line.length * Math.sin(line.angle));
    ctx.stroke();

    // Draw a circle at the end of the line if it should have a dot
    if (line.hasDot) {
      var endX = line.x + line.length * Math.cos(line.angle);
      var endY = line.y + line.length * Math.sin(line.angle);
      ctx.beginPath();
      ctx.arc(endX, endY, 5, 0, 2 * Math.PI); // change 5 to the radius you want for the dot
      ctx.fillStyle = line.dotColor; // color from line
      ctx.fill();
    }

    // Move line
    line.x += line.speed * Math.cos(line.angle);
    line.y += line.speed * Math.sin(line.angle);

    // If line is out of bounds, reset it
    if (line.x < 0 || line.y < 0 || line.x > canvas.width || line.y > canvas.height) {
      lines[i] = generateLine(mouseX, mouseY);
    }
  }

  requestAnimationFrame(drawLines); // repeat
}
document.addEventListener('mousemove', function(event) {
  mouseX = event.clientX;
  mouseY = event.clientY;
});

drawLines(); 

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

