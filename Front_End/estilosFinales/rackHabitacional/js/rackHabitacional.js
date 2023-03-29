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
  
  if (panel.style.display === "none") {
    panel.style.display = "block";
  } else {
    panel.style.display = "none";
  }
}

document.getElementById("mostrar").addEventListener("click", togglePanel);



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




/*para ajustar el tamaño y posicion de los estados de forma dinamica*/

function addAjusteEstado(numDias) {
  const taskContainer = document.querySelector('.task-container');
  const nuevoEstado = document.createElement('div');
  nuevoEstado.classList.add('ajuste');
  nuevoEstado.classList.add(`ajuste-${numDias}dias`);
  nuevoEstado.style.width = `calc(${numDias * 75}% - 1px)`;
  nuevoEstado.style.overflowWrap = 'break-word';
  taskContainer.appendChild(nuevoEstado);
}