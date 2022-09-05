document.addEventListener("DOMContentLoaded", () => {

const navClose = () => {

  
  const navbarOpen = document.querySelector('.nav-mob.show-nav');
  const navItems = document.querySelectorAll(".nav-item");

 

    const navbar = document.querySelector('.nav-mob');
    const burger = document.querySelector('.burger');
    const mainNav = document.querySelector(".main-nav");

    navItems.forEach(item => {

      item.addEventListener('click', (e) => {

        var width = window.innerWidth;

        if (width < 800) {
          mainNav.classList.toggle('show-nav');
          navbar.classList.toggle('show-nav');
        }
      })
    })
  
}

navClose();

});