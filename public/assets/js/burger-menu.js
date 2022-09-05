document.addEventListener("DOMContentLoaded", () => {

function toggleMenu () {  
    const navbar = document.querySelector('.nav-mob');
    const burger = document.querySelector('.burger');
    const mainNav = document.querySelector('.main-nav');

    burger.addEventListener('click', (e) => {    
      navbar.classList.toggle('show-nav');
      mainNav.classList.toggle('show-nav');
    });    
  }
  toggleMenu();

});
