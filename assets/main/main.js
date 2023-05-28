    var navUp = document.querySelector('#navUp');
        var navbarMenu = document.querySelector('.navbar-menu');
        var bars = document.querySelectorAll('.bar');
        var container = document.querySelector('.container');
        function toggleMenu() {
        navbarMenu.classList.toggle('active');
        bars.forEach(function(bar) {
            bar.classList.toggle('cross');
        });
        }
        navUp.addEventListener('click', toggleMenu);
        function setNavbarBackground() {
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        var header = document.querySelector('.navbar');
    
        if (scrollTop > 20) {
            header.classList.add('navbar-shrink');
        } else {
            header.classList.remove('navbar-shrink');
        }
        }
        window.addEventListener('scroll', setNavbarBackground);
        
    const header = document.querySelector('.box-header');
    const headerTitle = document.querySelector('.header__title');
    const headerText = document.querySelector('.header__text');
    const boxLinks = document.querySelectorAll('.box__link'); 
    const textColor= ['rgba(255, 0, 0, 0.5)', 'rgba(0, 255, 0, 0.5)', 'rgba(0, 0, 255, 0.5)'];
    const linkColor= ['#c001c1', '#c000c2', '#e2aea2'];
    const bgColors= ['rgba(29, 204, 225, 0.5)', 'rgba(121, 154, 255, 0.5)', 'rgba(229, 114, 235, 0.5)'];
    const boxes = document.querySelectorAll('.box');
    
    const images = [
      '../uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg',
      '../uploads/pexels-quang-nguyen_8ca6b53cdb562332.jpg',
    ];
    
    const data = [
      {
        title: 'Nauja Antraštė 1',
        text: ' Naujas Trumpas tekstas 1v Naujas Trumpas tekstas 1v\n Naujas Trumpas tekstas 1v Naujas Trumpas tekstas 1v Naujas Trumpas tekstas 1v',
        link: 'nuoroda-1',
    },
      {
        title: 'Nauja Antraštė 2',
        text: 'Naujas Trumpas tekstas 2v Naujas Trumpas tekstas 2v Naujas \nTrumpas tekstas 2v Naujas Trumpas tekstas 2v',
        link: 'nuoroda-2',
    },
    ];
    
    boxes.forEach((box, index) => {
      box.style.backgroundColor = bgColors[index];
      box.style.color = textColor[index];
      boxLinks[index].style.color = linkColor[index];
    });
    
    let intervalId;
    
    function startInterval() {
      intervalId = setInterval(() => {
        currentIndex = (currentIndex + 1) % images.length;
        updateContent(currentIndex);
      }, 6000);
    }
    
    function updateContent(index) {
      header.style.backgroundImage = `url(${images[index]})`;
      headerTitle.innerText = data[index].title;
      headerText.innerText = data[index].text;
    }
    
    updateContent(0);
    startInterval();
    let currentIndex = 0;
    

  