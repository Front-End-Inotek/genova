<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark">RESERVACIONES</h2></div>
          
          <div class="row">
            <div class="col-sm-4 text-center"><input type="text" id="a_buscar" placeholder="Buscar en tipos" onkeyup="buscar_tipo()" class="color_black form-control form-control-lg" autofocus="autofocus"/></div>
            <div class="col-sm-4 text-center"></div>
            <div class="col-sm-4 text-center"><button onclick="reporte_tipo()" class="btn btn-primary" >Reporte de Tipo</button></div>
          </div></br>
          <div id="paginacion_tipos">';
          $cat_paginas = $reservacion->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_tipos_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
