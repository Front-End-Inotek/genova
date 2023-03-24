

function mostrarHabitaciones(selector, boton) {
  // Oculta todas las habitaciones
  var habitaciones = document.querySelectorAll('.btn');
  for (var i = 0; i < habitaciones.length; i++) {
    habitaciones[i].style.display = 'none';
  }

  // Muestra solo las habitaciones seleccionadas
  var habitacionesSeleccionadas = document.querySelectorAll(selector);
  for (var i = 0; i < habitacionesSeleccionadas.length; i++) {
    habitacionesSeleccionadas[i].parentNode.style.display = 'inline-block';
  }
  
  // Muestra el botón "Mostrar todas las habitaciones"
  boton.style.display = 'inline-block';
}

function mostrarTodasLasHabitaciones(boton) {
  // Muestra todas las habitaciones
  var habitaciones = document.querySelectorAll('.btn');
  for (var i = 0; i < habitaciones.length; i++) {
    habitaciones[i].style.display = 'inline-block';
  }
  
  // Oculta el botón "Mostrar todas las habitaciones"
  boton.style.display = 'none';
}

// Muestra habitaciones vacías y sucias
var botonMostrarVaciasSucias = document.getElementById('mostrar-vacias-sucias');
botonMostrarVaciasSucias.addEventListener('click', function() {
  mostrarHabitaciones('.vacia-sucia', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones reservadas y pagadas
var botonMostrarReservadasPagadas = document.getElementById('mostrar-reservadas');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.reserva-pagada', botonMostrarTodasLasHabitaciones);
});

// Botón "Mostrar todas las habitaciones"
var botonMostrarTodasLasHabitaciones = document.getElementById('mostrar-todas');
botonMostrarTodasLasHabitaciones.addEventListener('click', function() {
  mostrarTodasLasHabitaciones(botonMostrarTodasLasHabitaciones);

});