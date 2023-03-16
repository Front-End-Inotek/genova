
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
/* cards click debajo */
/*
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
*/

// Cards aparecen arriba con informacion
const tarjetas = document.getElementsByClassName('card');

// Declarar un arreglo para almacenar la información original de cada tarjeta
let informacionOriginal = [];

// Recorrer todas las tarjetas y agregar el evento de clic a cada una
for (let i = 0; i < tarjetas.length; i++) {
  // Agregar la información original de la tarjeta actual al arreglo
  informacionOriginal.push(tarjetas[i].innerHTML);

  tarjetas[i].addEventListener('click', () => {
    // Si la tarjeta muestra la información original, cambiarla a la nueva información
    if (tarjetas[i].innerHTML === informacionOriginal[i]) {
      // Obtener la nueva información para la tarjeta
      const nuevaInformacion = obtenerNuevaInformacion();

      // Actualizar el contenido de la tarjeta con la nueva información
      tarjetas[i].innerHTML = nuevaInformacion;
    } else {
      // Si la tarjeta muestra la nueva información, cambiarla de vuelta a la información original
      tarjetas[i].innerHTML = informacionOriginal[i];
    }
  });
}

// Función para obtener la nueva información
function obtenerNuevaInformacion() {
  // Aquí se puede hacer una llamada a una API o generar dinámicamente la información

  // Retorna la nueva información como una cadena HTML
  return `
  <div class="card cards2">
  <h3 class="titulo" style="color: #05311d;">Informacion<span  style="color: #090909;"> Nombre  **  Salida 08/04  Cargo Extra $200   <span style="color: orange;">Mantenimiento programado 12pm</span></h3>
  <div class="circulo">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
    <circle class="stroke" cx="20" cy="20" r="0"/>
  </svg>
  </div>
</div>
  `;
}