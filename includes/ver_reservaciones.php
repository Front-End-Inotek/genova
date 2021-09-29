<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark">RESERVACIONES</h2></div>
          
          <div class="row">
            <div class="col-sm-2">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_reservacion()" class="color_black form-control form-control-lg" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Inicial:</div>
            <div class="col-sm-2">
              <input class="form-control form-control-lg" type="date"  id="inicial"  placeholder="Requisicion inicial" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Final:</div>
            <div class="col-sm-2">
              <input class="form-control form-control-lg" type="date" id="final" placeholder="Requisicion final" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-outline-primary btn-block btn-default btn-lg" onclick="busqueda_requisicion()">
                Buscar 
              </button>
            </div>
          </div><br>
          <div id="paginacion_reservaciones">';
          $cat_paginas = $reservacion->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_reservaciones_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
