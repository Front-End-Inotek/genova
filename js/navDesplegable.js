/* para cambiar entre racks*/
function switch_rack() {
  var checkfactura = document.getElementById("flexSwitchCheckDefault");
  if (checkfactura.checked == true) {
    //console.log("rack de operaciones");
    alert('si');
  } else {
    //console.log("rack de habitaciones");
    alert('si');
  }
}

function sub_menu(){
  closeNav()
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

const showMenu = (id) => {
  //console.log(id)
  const submenu = document.getElementById(`${id}`)
  //console.log(submenu)
  /* if (submenu.style.display === "" ||  submenu.style.display === "none"){
    console.log("Mostrar menu")
    submenu.style.display = "block"
    submenu.setAttribute("style", "display : block;")
  }else if(submenu.style.display === "block"){
    console.log("Ocultar menu")
    submenu.style.display = "none"
    submenu.setAttribute("style", "display : none;")
  }else {
    submenu.style.display = "none"
  } */
  //////////////////
  /* if(submenu.style.display === "none"){
    submenu.style.display = "block";
  }else{
    submenu.style.display = "none"
  } */
  submenu.classList.toggle("ocultarMenus")
}
//cambiar el texto del rack
function cambiarVista() {
  var checkbox = document.getElementById("flexSwitchCheckDefault");
  var vista = document.getElementById("vista");
  txt_vista = localStorage.getItem("txt_vista");
  //console.log(txt_vista)
  if (checkbox.checked != true) {
    vista.classList.remove("rack-operaciones");
    vista.classList.add("vista-habitacional");
    vista.innerHTML = txt_vista;
  } else {
    vista.classList.remove("vista-habitacional");
    vista.classList.add("rack-operaciones");
    vista.innerHTML =txt_vista;
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

function handleSiceTable () {
  const nav = document.getElementById("asidenav");
  const menusText = document.getElementsByClassName("aside_nav_link_text");
  const rutas = document.getElementsByClassName("aside_nav_link_containerInfo_links");
  const btnSwitch = document.getElementById("switch_container_menu");
  const nombre = document.getElementById("nombreNav");
  const contenedor = document.getElementsByClassName("aside_nav_link_container");
  const contenedor2 = document.getElementsByClassName("aside_nav_link_containerMore");
  const contenedor3 = document.getElementsByClassName("aside_nav_link_containerInfo");
  const imgBurger = document.getElementById("img-hamburger")

  nombre.classList.toggle("d-none");

  nav.classList.toggle("aside_nav_container_open");
  btnSwitch.classList.toggle("aside_nav_menu_switch_container_show");
  for (let i = 0; i < menusText.length; i++) {
    menusText[i].classList.toggle("aside_nav_link_show");
  }
  for ( let i = 0; i < rutas.length; i++ ) {
    rutas[i].classList.remove("ocultarMenus")
  }
  for ( let i = 0; i < contenedor.length; i++) {
    contenedor[i].classList.toggle("space_around")
  }
  for ( let i = 0; i < contenedor2.length; i++) {
    contenedor2[i].classList.toggle("space_around")
  }
  for ( let i = 0; i < contenedor3.length; i++) {
    contenedor3[i].classList.toggle("space_around")
  }

  if ( nav.classList.contains("aside_nav_container_open")) {
    imgBurger.src = "./assets/icons-nav/close.svg"
  } else {
    imgBurger.src = "./assets/icons-nav/burger.svg"
  }
}