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



//tamaño adaptable de 2 o mas espados dependiendo el colspan (duracion)
function ajusteDeAncho(tableId) {
  const table = document.getElementById(tableId);
  const cells = table.getElementsByTagName("td");

  // Recorrer todas las celdas
  for (let i = 0; i < cells.length; i++) {
    const cell = cells[i];

    // Si la celda tiene un colspan mayor a 1
    if (cell.colSpan > 1) {
      // Calcular el ancho de la celda
      const width = (cell.colSpan * 75) - 1;

      // Agregar la regla CSS a la celda
      cell.style.width = `calc(${width}% - 1px)`;
    }
  }
}