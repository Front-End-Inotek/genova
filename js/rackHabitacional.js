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