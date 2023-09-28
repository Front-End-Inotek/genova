
/*
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

   // Guarda la información de visibilidad de las habitaciones en el almacenamiento local
  localStorage.setItem('habitacionesVisibles', selector);
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
*/
//botones de estado para ocultarlos o mostrarlos
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
  boton.style.display = 'inline-block';
  // Guarda la información de visibilidad de las habitaciones en el almacenamiento local
  localStorage.setItem('habitacionesVisibles', selector);
}

function mostrarTodasLasHabitaciones(boton) {
  // Muestra todas las habitaciones
  var habitaciones = document.querySelectorAll('.btn');
  for (var i = 0; i < habitaciones.length; i++) {
    habitaciones[i].style.display = 'inline-block';
  }

  // Oculta el botón "Mostrar todas las habitaciones"
  boton.style.display = 'none';

  // Borra la información de visibilidad de las habitaciones del almacenamiento local
  localStorage.removeItem('habitacionesVisibles');
}

function agregarEventoDeMostrarHabitaciones(boton, selector) {
  // Recupera la información de visibilidad de las habitaciones del almacenamiento local
  var habitacionesVisibles = localStorage.getItem('habitacionesVisibles');
  if (habitacionesVisibles) {
    // Si hay información guardada, muestra las habitaciones correspondientes
    mostrarHabitaciones(habitacionesVisibles, botonMostrarTodasLasHabitaciones);
  } else {
    // Si no hay información guardada, muestra todas las habitaciones
    mostrarTodasLasHabitaciones(botonMostrarTodasLasHabitaciones);
  }

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

/*
function seleccionarCheckbox() {
    var radio = document.getElementById("yes");
    var checkbox = document.getElementById("confirmacion");

    if (radio.checked) {
      checkbox.checked = true;
    } else {
      checkbox.checked = false;
    }
  }*/