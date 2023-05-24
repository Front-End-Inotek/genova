<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $opcion=2;
  $incial = $_GET['inicial'];
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">REPORTE DE SALIDAS</h2></div>
    
          <div class="row">
            <div class="col-sm-2">';
              echo '<input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_llegadas_salidas(event,'.$opcion.')" class="color_black form-control form-control" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Inicial:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date"  id="inicial"  placeholder="Reservacion inicial" autofocus="autofocus"/>
            </div>
            
            <div class="col-sm-1">
              <button class="btn btn-success btn-block btn-default" onclick="ver_reportes_salidas()">
                Buscar 
              </button>
            </div>
           
          </div><br>
          <div id="paginacion_reservaciones">';
          $cat_paginas = $reservacion->mostrar_salidas(1,$_GET['usuario_id'],$incial);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_reservaciones_paginacion('.$i.','.$id_paginacion.',2)">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
