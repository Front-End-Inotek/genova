const botonMostrar = document.getElementById("mostrar");
const panel = document.getElementById("panel");

botonMostrar.addEventListener("click", function() {
  if (panel.style.display === "none") {
    panel.style.display = "block";
  } else {
    panel.style.display = "none";
  }
});



 function mostrarInformacion() {

   swal({
     title: "Información",
     text: "Informacion del Huesped",
     icon: "info",
     button: "OK",
   });
 };

 const tasks = document.querySelectorAll(".task");

 tasks.forEach(task => {
  task.addEventListener("click", mostrarInformacion);
});


// Creamos una función para agregar la regla CSS
function agregarReglasCSS(elemento) {
  var elementosHijos = elemento.children;
  
  for (var i = 0; i < elementosHijos.length; i++) {
    var hijo = elementosHijos[i];
    var colspan = hijo.getAttribute('colspan');
    
    if (colspan) {
      var reglaCSS = "width: calc(" + (75/colspan) + "% - 1px);";
      hijo.style.cssText += reglaCSS;
    }
  }
}



// Seleccionar todas las celdas de la tabla
var celdas = document.querySelectorAll("td.celdaCompleta");

// Recorrer cada celda
for (var i = 0; i < celdas.length; i++) {
  // Seleccionar los divs "medioDia" dentro de la celda
  var medioDiaDivs = celdas[i].querySelectorAll("div.medioDia");

  // Recorrer cada div "medioDia" y asignarle un ID único
  for (var j = 0; j < medioDiaDivs.length; j++) {
    medioDiaDivs[j].id = (i + 1) + "." + (j + 1);
  }
}


// Se seleccionan todas las clase medioDia
const medioDias = celda.querySelectorAll('.medioDia');

// define una función anónima que recibe dos parámetros, medioDia  y indiceMedioDia.
medioDias.forEach((medioDia, indiceMedioDia) => {

    //crea una constante llamada "idMedioDia" que contiene el id separado por un .
    const idMedioDia = `${indiceCelda + 1}.${indiceMedioDia + 1}`;

    //agrega un atributo "id" con el valor de "idMedioDia" al elemento actual de la iteración "medioDia".
    medioDia.setAttribute('id', idMedioDia);
});





