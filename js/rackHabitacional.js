/*const botonMostrar = document.getElementById("mostrar");
const panel = document.getElementById("panel");

botonMostrar.addEventListener("click", function() {
  if (panel.style.display === "none") {
    panel.style.display = "block";
  } else {
    panel.style.display = "none";
  }
});*/

function togglePanel() {
  const botonMostrar = document.getElementById("mostrar");
  const panel = document.getElementById("panel");
  botonMostrar.onclick = function() {
    if (panel.style.display === "none") {
      panel.style.display = "block";
    } else {
      panel.style.display = "none";
    }
  };
}

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

/************************************* */
/* ***funcion par sobre poner ***********/
/***** 2 estados en un mismo dia*********
/* ****tener en cuenta el tamaño con span */



//tamaño adaptable de 2 o mas espados dependiendo el colspan
function ajusteDeAncho(tablaTotal) {
  const table = document.getElementById(tablaTotal);
  const cells = table.getElementsByTagName("td");
  for (let i = 0; i < cells.length; i++) {
    const cell = cells[i];
    // Si la celda tiene un colspan mayor a 1
    if (cell.colSpan > 1) {
      let width = 0;
      for (let i = 0; i < cell.colSpan; i++) {
        width += 75;
      }
      width -= 1; // restar 1px para evitar problemas de desbordamiento
      cell.style.width = `calc(${width}% - 1px)`;
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
// const medioDias = celda.querySelectorAll('.medioDia');

// // define una función anónima que recibe dos parámetros, medioDia  y indiceMedioDia.
// medioDias.forEach((medioDia, indiceMedioDia) => {

//     //crea una constante llamada "idMedioDia" que contiene el id separado por un .
//     const idMedioDia = `${indiceCelda + 1}.${indiceMedioDia + 1}`;

//     //agrega un atributo "id" con el valor de "idMedioDia" al elemento actual de la iteración "medioDia".
//     medioDia.setAttribute('id', idMedioDia);
// });

var elementos = document.querySelectorAll(".blanco");
for (var i = 0; i < elementos.length; i++) {
  elementos[i].classList.add("efecto");
}
