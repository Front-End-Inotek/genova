<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_surtir_inventario.php");
  $surtir_inventario = NEW Surtir_inventario(0);

  echo ' <div class="main_container">
          <header class="main_container_title">
            <h2>SURTIR INVENTARIO</h2>
          </header>

          <div class="inputs_form_container justify-content-start">
            <div class="inputs_form_container justify-content-start">

              <div class="form-floating input_container_date">
                <input class="form-control form-control" type="date"  id="inicial"  placeholder="Surtir inventario inicial" autofocus="autofocus"/>
                <label for="inicial">Fecha inicial</label>
              </div>

              <div class="form-floating input_container_date">
                <input class="form-control form-control" type="date" id="final" placeholder="Surtir inventario final" autofocus="autofocus"/>
                <label for="final">Fecha final</label>
              </div>

              <div class="form-floating input_container">
                <button class="btn btn-primary" onclick="busqueda_surtir()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                  </svg>
                  Buscar
                </button>
              </div>

            </div>
          </div>

          <div id="paginacion_surtir_inventario">';
          $cat_paginas = $surtir_inventario->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_surtir_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>
  </div>';
  //comentario
?>
