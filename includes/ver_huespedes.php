<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">HUESPEDES</h2></div>
          
          <div class="row">
            <div class="col-sm-2">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_huesped(event)" class="color_black form-control form-control" />
            </div>
            <div class="col-sm-10"></div>
          </div><br>
          <div id="paginacion_huespedes">';
          $cat_paginas = $huesped->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_huespedes_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
