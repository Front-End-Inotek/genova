<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $titulo= $_GET['titulo'];
  $opcion=$_GET['opcion'];

  $inicial =$_GET['inicial'];
  $buscar= $_GET['buscar'];
  $inicial = urldecode($inicial);

  // print_r($inicial);

  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">'.$titulo.'</h2></div>
    
          <div id="paginacion_reservaciones">';
          $cat_paginas = $reservacion->mostrar_reportes_reservas(1,$_GET['usuario_id'],$opcion,$inicial,$buscar);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_reservaciones_paginacion_por_dia('.$i.','.$id_paginacion.','.$inicial.','.$buscar.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
