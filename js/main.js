// Scroll to button 
const scrollBtn = document.getElementById("scrollTopBtn");

window.addEventListener("scroll", () => {
    if ( window.scrollY >= 250 ){
        scrollBtn.classList.remove("hide");
    }else{
        scrollBtn.classList.add("hide");
    }
})

scrollBtn.addEventListener("click", () => {
    window.scrollTo({
        top:0,
        behavior:"smooth"
    })
})

// Menu hamburger
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");
const closeMenu = document.querySelector(".close-menu");


function toggleMenu(){
    navLinks.classList.toggle("active");
    closeMenu.classList.toggle('hide')

    const isOpen = navLinks.classList.contains("active");
    hamburger.setAttribute("aria-expanded", isOpen);
}

hamburger.addEventListener("click",toggleMenu);
closeMenu.addEventListener("click",toggleMenu);
