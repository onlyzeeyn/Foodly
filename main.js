// Scroll to button 
let scrollBtn = document.getElementById("scrollTopBtn");

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


