
/* para cambiar entre racks*/
function switch_rack() {

  var checkfactura = document.getElementById("flexSwitchCheckDefault");
  if (checkfactura.checked == true) {

    console.log("rack de operaciones");
    alert('si');

  } else {

    console.log("rack de habitaciones");
    alert('si');

  }
}

/*********************************************/
/* funcion para desplegar y ocultar el navbar*
/*********************************************/

function boton_menu() {
  let sidebar = document.querySelector("#sidebar");
  let container = document.querySelector(".my-container");
  sidebar.classList.toggle("active-nav");
  container.classList.toggle("active-cont");
}

/*********************************************/
/*funcion para desplegar y ocultar submenus**/
/*********************************************/

function sub_menu() {
  // Obtener todos los elementos del menú con clase "nav-link"
  var menuItems = document.querySelectorAll(".nav-link");

  // Iterar a través de cada elemento de menú y agregar un evento de clic
  menuItems.forEach(function (item) {
    var submenu = item.querySelector(".submenu");

    // Si el elemento de menú tiene un submenú y el evento de clic aún no se ha agregado, agregar evento de clic
    if (submenu && !item.classList.contains("has-click-event")) {
      item.addEventListener("click", function (event) {
        event.preventDefault();
        // Si el submenú está oculto, lo mostramos
        if (submenu.style.display === "none" || submenu.style.display === "") {
          submenu.style.display = "block";
        }
        // Si el submenú está visible, lo ocultamos
        else {
          submenu.style.display = "none";
        }
      });
      // Agregar clase al elemento del menú para indicar que se ha agregado el evento de clic
      item.classList.add("has-click-event");
    }
  });
}

//cambiar el texto del rack
function cambiarVista() {
  var checkbox = document.getElementById("flexSwitchCheckDefault");
  var vista = document.getElementById("vista");

  if (checkbox.checked == true) {
    vista.classList.remove("vista-habitacional");
    vista.classList.add("rack-operaciones"); 
    vista.innerHTML = "Vista Operaciones";
  } else {
    vista.classList.remove("rack-operaciones");
    vista.classList.add("vista-habitacional");
    vista.innerHTML = "Vista Habitacional";
  }
}

//funcion para cambiar a modo nocturno

function modoNocturno() {
  var body = document.body;
  var currentColor = body.style.backgroundColor;
  var boton = document.getElementById("filtro-noche");

  if (currentColor === "rgb(34, 34, 82)" || currentColor === "#222252") {
    // si el color actual es azul oscuro, cambiar de vuelta al color original y al icono de sol
    body.style.backgroundColor = "";
    boton.classList.remove("btn-sol");
    boton.querySelector("i").classList.remove("bx-sun");
    boton.querySelector("i").classList.add("icono-sol");
    body.classList.remove("modo-nocturno"); // eliminar la clase modo-nocturno del body
  } else {
    // si el color actual es diferente a azul oscuro, cambiar a azul oscuro y al icono de luna
    body.style.backgroundColor = "#222252";
    boton.classList.add("btn-sol");
    boton.querySelector("i").classList.add("bx-sun");
    boton.querySelector("i").classList.remove("icono-sol");
    boton.querySelector("i").classList.add("icono-luna");
    body.classList.add("modo-nocturno"); // agregar la clase modo-nocturno al body
  }
}

//desactivar la animacion de background

function ocultarMostrar() {
  var ul = document.querySelector(".circles");
  var lis = document.querySelectorAll(".circles li");
  if (ul.style.display === "none") {
    ul.style.display = "block";
    lis.forEach(function(li) {
      li.style.display = "block";
    });
  } else {
    ul.style.display = "none";
    lis.forEach(function(li) {
      li.style.display = "none";
    });
  }
}
