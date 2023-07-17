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
  /* let container = document.querySelector(".my-container"); */
  sidebar.classList.toggle("active-nav");

  // container.classList.toggle("active-cont");
  // if(container!=null){
  /* container.classList.toggle("active-cont"); */
  // }
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
        if (submenu.style.display === "none" || submenu.style.display == "") {
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

const showMenu = () => {
  console.log("show menu")
}
//cambiar el texto del rack
function cambiarVista() {
  var checkbox = document.getElementById("flexSwitchCheckDefault");
  var vista = document.getElementById("vista");
  if (checkbox.checked != true) {
    vista.classList.remove("rack-operaciones");
    vista.classList.add("vista-habitacional");
    vista.innerHTML = "Rack Habitacional";
  } else {
    vista.classList.remove("vista-habitacional");
    vista.classList.add("rack-operaciones");
    vista.innerHTML = "Rack Operaciones";
  }
}

//funcion para cambiar a modo nocturno

function modoNocturno() {
  var body = document.body;
  var boton = document.getElementById("filtro-noche");

  if (body.classList.contains("modo-nocturno")) {
    // Si la clase modo-nocturno está presente, cambiar al modo diurno
    body.classList.remove("modo-nocturno");
    boton.classList.remove("btn-sol");
    boton.querySelector("i").classList.remove("bx-sun");
    boton.querySelector("i").classList.add("icono-sol");
  } else {
    // Si la clase modo-nocturno no está presente, cambiar al modo nocturno
    body.classList.add("modo-nocturno");
    boton.classList.add("btn-sol");
    boton.querySelector("i").classList.add("bx-sun");
    boton.querySelector("i").classList.remove("icono-sol");
    boton.querySelector("i").classList.add("icono-luna");
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
