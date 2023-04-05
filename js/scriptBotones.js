

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



function agregarEventoDeMostrarHabitaciones(boton, selector) {
  boton.onclick = function() {
    mostrarHabitaciones(selector, botonMostrarTodasLasHabitaciones);
  };

}

var botonMostrarTodasLasHabitaciones = document.getElementById('mostrar-todas');
agregarEventoDeMostrarHabitaciones(botonMostrarTodasLasHabitaciones, '');

var botonMostrarReservadasPagadas = document.getElementById('mostrar-disponibles');
agregarEventoDeMostrarHabitaciones(botonMostrarReservadasPagadas, '.disponible-limpiaVisible');

var botonMostrarVaciasSucias = document.getElementById('mostrar-vacias-sucias');
agregarEventoDeMostrarHabitaciones(botonMostrarVaciasSucias, '.vacia-suciaVisible');

var botonMostrarReservadasPagadasSucias = document.getElementById('mostrar-ocupada-sucias');
agregarEventoDeMostrarHabitaciones(botonMostrarReservadasPagadasSucias, '.sucia-ocupadaVisible');

var botonMostrarVaciasLimpieza = document.getElementById('mostrar-vacia-limpieza');
agregarEventoDeMostrarHabitaciones(botonMostrarVaciasLimpieza, '.vacia-limpiaVisible');

var botonMostrarOcupadasLimpieza = document.getElementById('mostrar-ocupada-limpieza');
agregarEventoDeMostrarHabitaciones(botonMostrarOcupadasLimpieza, '.ocupada-limpiezaVisible');

var botonMostrarReservasPendientes = document.getElementById('mostrar-reservada-pendiente');
agregarEventoDeMostrarHabitaciones(botonMostrarReservasPendientes, '.reserva-pendienteVisible');

var botonMostrarReservasPagadas = document.getElementById('mostrar-reservada-pagada');
agregarEventoDeMostrarHabitaciones(botonMostrarReservasPagadas, '.reserva-pagadaVisible');

var botonMostrarMantenimiento = document.getElementById('mostrar-mantenimiento');
agregarEventoDeMostrarHabitaciones(botonMostrarMantenimiento, '.mantenimientoVisible');

var botonMostrarUsoCasa = document.getElementById('mostrar-uso-casa');
agregarEventoDeMostrarHabitaciones(botonMostrarUsoCasa, '.usoCasaVisible');

var botonMostrarBloqueo = document.getElementById('mostrar-bloqueo');
agregarEventoDeMostrarHabitaciones(botonMostrarBloqueo, '.bloqueoVisible');

//botones de estado para ocultarlos o mostrarlos
function toggleBotones() {
  var botones = document.getElementById("botones");
  if (botones.classList.contains("botones-mostrados")) {
      botones.classList.remove("botones-mostrados");
      botones.classList.add("botones-ocultos");
  } else {
      botones.classList.remove("botones-ocultos");
      botones.classList.add("botones-mostrados");
  }
}




/*
// Botón "Mostrar todas las habitaciones"
var botonMostrarTodasLasHabitaciones = document.getElementById('mostrar-todas');
botonMostrarTodasLasHabitaciones.addEventListener('click', function() {
  mostrarTodasLasHabitaciones(botonMostrarTodasLasHabitaciones);

});*/

/*
// Muestra habitaciones disponibles
var botonMostrarReservadasPagadas = document.getElementById('mostrar-disponibles');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.disponible-limpiaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones sucias vacias
var botonMostrarVaciasSucias = document.getElementById('mostrar-vacias-sucias');
botonMostrarVaciasSucias.addEventListener('click', function() {
  mostrarHabitaciones('.vacia-suciaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones sucias ocupadas
var botonMostrarReservadasPagadas = document.getElementById('mostrar-ocupada-sucias');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.sucia-ocupadaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones vacias en limpieza
var botonMostrarReservadasPagadas = document.getElementById('mostrar-vacia-limpieza');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.vacia-limpiaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones ocupadas en limpieza
var botonMostrarReservadasPagadas = document.getElementById('mostrar-ocupada-limpieza');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.ocupada-limpiezaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones reservadas y pagadas
var botonMostrarReservadasPagadas = document.getElementById('mostrar-reservada-pendiente');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.reserva-pendienteVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones reservadas y pendientes de pago
var botonMostrarReservadasPagadas = document.getElementById('mostrar-reservada-pagada');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.reserva-pagadaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones en mantenimiento
var botonMostrarReservadasPagadas = document.getElementById('mostrar-mantenimiento');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.mantenimientoVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones en Uso por Casa
var botonMostrarReservadasPagadas = document.getElementById('mostrar-uso-casa');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.usoCasaVisible', botonMostrarTodasLasHabitaciones);
});

// Muestra habitaciones en Bloqueo
var botonMostrarReservadasPagadas = document.getElementById('mostrar-bloqueo');
botonMostrarReservadasPagadas.addEventListener('click', function() {
  mostrarHabitaciones('.bloqueoVisible', botonMostrarTodasLasHabitaciones);
});
*/
/*********************************/
/*variante de la funcion de arriba*/
/****/

