
/********************************************************/
/* esta es la funcion para desplegar y ocultar el navbar*/
/********************************************************/


let menu_btn = document.querySelector("#menu-btn");
let sidebar = document.querySelector("#sidebar");
let container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
  sidebar.classList.toggle("active-nav");
  container.classList.toggle("active-cont");
});

/*************************************************************/
/* aqui termina la funcion para desplegar y ocultar el navbar*/
/*************************************************************/

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('link1').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  
  document.getElementById('link2').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#target2').scrollIntoView({
      behavior: 'smooth'
    });
  });
  
  document.getElementById('link3').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#target3').scrollIntoView({
      behavior: 'smooth'
    });
  });
  
  document.getElementById('link4').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#target4').scrollIntoView({
      behavior: 'smooth'
    });
  });
  
  document.getElementById('link5').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#target5').scrollIntoView({
      behavior: 'smooth'
    });
  });
  
  function scrolly() {
    var lastScroll = 0;
    
    window.addEventListener('scroll', function() {
      var st = window.pageYOffset || document.documentElement.scrollTop;
      
      if (st > lastScroll) {
        document.querySelector('nav').classList.add('fixedAtTop');
      } else {
        document.querySelector('nav').classList.remove('fixedAtTop');
      }
      
      lastScroll = st;
    });
    
    document.querySelector('nav').addEventListener('mouseover', function() {
      this.classList.remove('fixedAtTop');
    });
  }
  
  scrolly();
});



/* Cards nuevas con click*/ 
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
<div class="cards2">
<h6 class="titulo" style="color: #05311d;">Informacion<span  style="color: #090909;">   <span style="color: orange;">Mantenimiento programado 12pm</span></h6>
<div class="circulo">
  <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
  <circle class="stroke" cx="20" cy="20" r="0"/>
</svg>
</div>
</div>
`;
}
//Cards flip
document.addEventListener("DOMContentLoaded", function() {
  var cards = document.querySelectorAll('.card');
  cards.forEach(function(card) {
    card.addEventListener('click', function(event) {
      event.currentTarget.classList.toggle('flipped');
    });
  });
});


