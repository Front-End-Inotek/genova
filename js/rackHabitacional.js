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
function estadoMismoDia() {
  const taskContainer = document.querySelector('.task-container');
  const ajusteElementos = taskContainer.querySelectorAll('.ajuste');

  ajusteElementos.forEach((ajusteElement) => {
    const siguiente = ajusteElement.siguiente;
    const anterior = ajusteElement.anterior;

    if (siguiente && anterior &&
        siguiente.classList.contains('ajuste') &&
        anterior.classList.contains('ajuste')) {
      ajusteElement.classList.add('ajuste-2dias');
    }
  });
}
