<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  $tipo= NEW Tipo(0);
  
  echo ' <div class="container-fluid">
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark">TIPOS DE HABITACIONES</h2></div>
          
          <div class="row">
            <div class="col-sm-4 text-center"><input type="text" id="a_buscar" placeholder="Buscar en tiposs" onkeyup="buscar_tipo()" class="color_black form-control form-control-lg" autofocus="autofocus"/></div>
            <div class="col-sm-4 text-center"></div>
            <div class="col-sm-4 text-center"><button onclick="reporte_tipo()" class="btn btn-primary btn-lg" >Reporte de Tipo</button></div>
          </div></br>
          <div id="paginacion_tipos">';
          $cat_paginas = $tipo->mostrar(1,$_GET['id']);
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
