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
