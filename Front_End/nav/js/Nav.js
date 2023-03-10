
const body = document.body;
const bgColorsBody = ["#f7fbfc", "#d6e6f2", "#b9d7ea", "#769fcd", "#cffff1"];
const menu = body.querySelector(".menu");
const menuItems = menu.querySelectorAll(".menu__item");
const menuBorder = menu.querySelector(".menu__border");
let activeItem = menu.querySelector(".active");

function clickItem(item, index) {

    menu.style.removeProperty("--timeOut");
    
    if (activeItem == item) return;
    
    if (activeItem) {
        activeItem.classList.remove("active");
    }

    
    item.classList.add("active");
    body.style.backgroundColor = bgColorsBody[index];
    activeItem = item;
    offsetMenuBorder(activeItem, menuBorder);
    
    
}

function offsetMenuBorder(element, menuBorder) {

    const offsetActiveItem = element.getBoundingClientRect();
    const left = Math.floor(offsetActiveItem.left - menu.offsetLeft - (menuBorder.offsetWidth  - offsetActiveItem.width) / 2) +  "px";
    menuBorder.style.transform = `translate3d(${left}, 0 , 0)`;

}

offsetMenuBorder(activeItem, menuBorder);

menuItems.forEach((item, index) => {

    item.addEventListener("click", () => clickItem(item, index));
    
})

window.addEventListener("resize", () => {
    offsetMenuBorder(activeItem, menuBorder);
    menu.style.setProperty("--timeOut", "none");
});
/* cards click */
var cards = document.querySelectorAll('.card');

cards.forEach(function(card) {
    card.addEventListener('click', function() {
      if (this.style.opacity == 0) {
        // Si la tarjeta esta oculta, la vuelve visible
        this.style.transform = "none";
        this.style.opacity = 1;
        this.style.transition = "transform 0.5s ease-out, opacity 0.5s ease-out";
      } else {
        // Si la tarjeta está visible, ocultarla
        this.style.transform = "perspective(1000px) rotateY(30deg) rotateX(20deg) translateX(30%) translateY(-10%)";
        this.style.opacity = 0;
        this.style.transition = "transform 0.5s ease-out, opacity 0.5s ease-out";
      }
    });
  });