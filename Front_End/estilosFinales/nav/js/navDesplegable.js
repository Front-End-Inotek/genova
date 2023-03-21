/********************************************************/
/* esta es la funcion para desplegar y ocultar el navbar*/
/********************************************************/

/*
let menu_btn = document.querySelector(".menu-btn");
let sidebar = document.querySelector("#sidebar");
let container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
  sidebar.classList.toggle("active-nav");
  container.classList.toggle("active-cont");
});*/

/*************************************************************/
/* aqui termina la funcion para desplegar y ocultar el navbar*/
/*************************************************************/
const botonMostrar = document.getElementById("mostrar");
const panel = document.getElementById("panel");

botonMostrar.addEventListener("click", function() {
  if (panel.style.display === "none") {
    panel.style.display = "block";
  } else {
    panel.style.display = "none";
  }
});