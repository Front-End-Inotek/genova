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
