/*cambio de color*/ 
const root = document.querySelector(":root"),
      inputs = document.querySelectorAll("input[name='theme']");

const theme = localStorage.getItem("theme-color");

const updateRoot = value => root.style.setProperty("--theme-color", `var(--${value})`);

for(const input of inputs) {
  if(theme && input.value === theme) {
    input.checked = true;
    
    updateRoot(theme);
  }
  
  input.onchange = e => {
    updateRoot(e.target.value);
    
    localStorage.setItem("theme-color", e.target.value);
  }
}

/*boton del menu */

let menu_btn = document.querySelector("#menu-btn");
let sidebar = document.querySelector("#sidebar");
let container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
  sidebar.classList.toggle("active-nav");
  container.classList.toggle("active-cont");
});

/* movimiento del side nav*/
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


  // Selecciona cada botón por su ID y agrega un evento de clic a cada uno
  var habitacion1 = document.getElementById("habitacion1");
  habitacion1.addEventListener("click", function() {
    swal("Habitación 1", "Esta habitación está ocupada", "warning");
  });

  var habitacion2 = document.getElementById("habitacion2");
  habitacion2.addEventListener("click", function() {
    swal("Habitación 2", "Esta habitación está en limpieza", "info");
  });

  var habitacion3 = document.getElementById("habitacion3");
  habitacion3.addEventListener("click", function() {
    swal("Habitación 3", "Esta habitación está disponible", "success");
  });

  var habitacion4 = document.getElementById("habitacion4");
  habitacion4.addEventListener("click", function() {
    swal("Habitación 4", "Esta habitación está disponible por $1520", "success");
  });
  var habitacion5 = document.getElementById("habitacion5");
  habitacion5.addEventListener("click", function() {
    swal("Habitación 5", "Esta habitación está disponible pero en mantenimiento por 1 hora", "warning");
  });

