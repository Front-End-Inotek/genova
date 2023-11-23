<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $opcion=2;
  $incial = $_GET['inicial'];
  $final = $_GET['final'];
  if($_GET['btn']==0) {
    echo '
    <div class="main_container">

          <header class="main_container_title">
            <h2>REPORTE CANCELADAS</h2>
          </header>

          <div class="inputs_form_container justify-content-start">
            <div class="form-floating input_container" style="max-width: 400px;">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_canceladas(event,'.$opcion.')" class="form-control custom_input" autofocus="autofocus"/>
              <label for="a_buscar">Buscar</label>
            </div>

            <div class="form-floating input_container_date">
              <input class="form-control custom_input" type="date"  id="inicial"  placeholder="Reservacion inicial" autofocus="autofocus" placeholder="Inicial"/>
              <label for="inicial">Fecha inicial</label>
            </div>

            <div class="form-floating input_container_date">
              <input class="form-control custom_input" type="date"  id="final"  placeholder="Reservacion final" autofocus="autofocus"/>
              <label for="final">Fecha final</label>
            </div>

            <div class="form-floating input_container">
              <button type="button" class="btn btn-primary" onclick="ver_reportes_canceladas(1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
                Buscar
              </button>
            </div>

          </div>
          ';
    $cat_paginas = $reservacion->mostrar_canceladas(1, $_GET['usuario_id'], $incial,$final);
    echo '
        <div id="paginacion_reservaciones"></div>
    </div>
  ';

  }else{

  }

?>
