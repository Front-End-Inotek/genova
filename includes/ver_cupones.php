<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon(0);
  
  echo ' <div class="container-fluid blanco">
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CUPONES</h2></div>
          
          <div class="row">
            <div class="col-sm-2">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_cupon()" class="color_black form-control form-control" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Inicial:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date"  id="inicial"  placeholder="Cupon inicial" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Final:</div>
            <div class="col-sm-2">
              <input class="form-control form-control" type="date" id="final" placeholder="Cupon final" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-success btn-block btn-default" onclick="busqueda_cupon()">
                Buscar
              </button>
            </div>
          </div><br>
          <div id="paginacion_cupones">';
          $cat_paginas = $cupon->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>
         </div>';
  $id_paginacion=1;
  echo '
  
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_cupones_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }  
  echo ' </ul>';
  //comentario
?>
