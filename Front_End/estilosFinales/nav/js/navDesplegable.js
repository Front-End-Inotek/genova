/********************************************************/
/* esta es la funcion para desplegar y ocultar el navbar*/
/********************************************************/

let menu_btn = document.querySelector(".menu-btn");
let sidebar = document.querySelector("#sidebar");
let container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
  sidebar.classList.toggle("active-nav");
  container.classList.toggle("active-cont");
});



/*************************************************************/
/* al hacer click en un subitem se cierra la navbar solo es***
**** agregar la clase ocultar al elemento que se requiera ***/
/*************************************************************/




// Seleccione todos los elementos con la clase "ocultar"
let ocultar_btns = document.querySelectorAll(".ocultar");

// Agregar un evento de clic a cada elemento
ocultar_btns.forEach(function(ocultar_btn) {
  ocultar_btn.addEventListener("click", function() {
    // Acción que deseas realizar
    sidebar.classList.remove("active-nav");
    container.classList.remove("active-cont");
  });
});



/*para despleglar los sub menus*/

// Obtener todos los elementos del menú con clase "nav-link"
var menuItems = document.querySelectorAll(".nav-link");

// Iterar a través de cada elemento de menú y agregar un evento de clic
menuItems.forEach(function(item) {
  var submenu = item.querySelector(".submenu");

  // Si el elemento de menú tiene un submenú, agregar evento de clic
  if (submenu) {
    item.addEventListener("click", function(event) {
      event.preventDefault();
      // Si el submenú está oculto, lo mostramos
      if (submenu.style.display === "none") {
        submenu.style.display = "block";
      }
      // Si el submenú está visible, lo ocultamos
      else {
        submenu.style.display = "none";
      }
    });
  }
});




