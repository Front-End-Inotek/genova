<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  $herramienta= NEW Herramienta(0);
  
  echo ' <div class="container-fluid">
          <br>
          <div class="col-sm-12 text-center"><h1 class="text-primary">Herramientas</h1></div>
          
          <div class="row">
            <div class="col-sm-4 text-center"><input type="text" id="a_buscar" placeholder="Buscar en herramientas" onkeyup="buscar_herramienta()" class="color_black form-control form-control-lg" autofocus="autofocus"/></div>
            <div class="col-sm-4 text-center"></div>
            <div class="col-sm-4 text-center"><button onclick="reporte_herramienta()" class="btn btn-outline-primary btn-lg" >Reporte de Herramienta</button></div>
          </div></br>
          <div id="paginacion_herramientas">';
          $cat_paginas = $herramienta->mostrar(1,$_GET['id']);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_herramientas_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
