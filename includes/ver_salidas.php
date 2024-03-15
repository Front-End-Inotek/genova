<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $opcion=2;
  $incial = $_GET['inicial'];
  $final = $_GET['final'];
  $fecha_hoy = date('Y-m-d');
  if($_GET['btn']==0) {
    echo ' 
    <div class="main_container"> 
          <header class="main_container_title">
            <h2 >Reporte de salidas</h2>
          </header>

          <div class="inputs_form_container justify-content-start">
            <div class="form-floating">
              <input type="text" class="form-control custom_input" id="a_buscar" placeholder="Buscar" onkeyup="buscar_llegadas_salidas(event,'.$opcion.')" />
              <label for="a_buscar" >Buscar</label>
            </div>

            <div class="form-floating">
              <input type="date" class="form-control custom_input" id="inicial" placeholder="Buscar" value="'.$fecha_hoy.'" />
              <label for="a_buscar" >Fecha inicial</label>
            </div>

            <div class="form-floating">
              <input type="date" class="form-control custom_input" id="final" placeholder="Buscar" value="'.$fecha_hoy.'" />
              <label for="inicial" >Fecha final</label>
            </div>

            <div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="radioReporte" id="salidas" checked>
                <label class="form-check-label" for="salidas">
                  Salidas
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="radioReporte" id="proximas">
                <label class="form-check-label" for="proximas">
                  Proximas a salir
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="radioReporte" id="todas" >
                <label class="form-check-label" for="todas">
                  Todas
                </label>
              </div>
            </div>

            <div class="form-floating">
              <button class="btn btn-primary" onclick="ver_reportes_salidas(1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                Buscar
              </button>
            </div>
          </div>

          <div id="paginacion_reservaciones">';
          
    $cat_paginas = $reservacion->mostrar_salidas(1, $_GET['usuario_id'], $incial,$final);
    echo '
          </div>
         </div>';
    $id_paginacion=1;
    $NUM_REPORTE=11;
    echo '
  <nav aria-label="Page navigation">
      <ul class="pagination">';
      for($i = 1; $i <= $cat_paginas; $i++) {
          echo '
          <li class="page-item">
            <a class="page-link" href="#" onclick="ver_reservaciones_paginacion('.$i.','.$id_paginacion.','.$NUM_REPORTE.')">
              <span aria-hidden>'.$i.'</span>
            </a>
          </li>';
          $id_paginacion=$id_paginacion+20;
      }
      echo '
      </ul>
    </nav>
    ';
  }else{

  }
  //comentario
?>
