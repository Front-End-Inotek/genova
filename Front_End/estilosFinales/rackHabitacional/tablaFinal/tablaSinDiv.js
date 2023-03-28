const botonMostrar = document.getElementById("mostrar");
const panel = document.getElementById("panel");

botonMostrar.addEventListener("click", function() {
  if (panel.style.display === "none") {
    panel.style.display = "block";
  } else {
    panel.style.display = "none";
  }
});


 // Obtener el elemento de sección por ID
 var sectionElement = document.querySelector(".task");

 // Agregar un controlador de eventos de clic al elemento de sección
 sectionElement.addEventListener("click", function() {
   // Mostrar una alerta SweetAlert con información
   swal({
     title: "Información",
     text: "Informacon del Huesped",
     icon: "info",
     button: "OK",
   });
 });