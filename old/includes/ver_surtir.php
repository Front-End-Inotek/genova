<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_surtir_inventario.php");
  $surtir_inventario = NEW Surtir_inventario(0);
  
  echo ' <div class="container blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">SURTIR INVENTARIO</h2></div>
          
          <div class="row">
            <div class="col-sm-2">Fecha Inicial:</div>
            <div class="col-sm-3">
              <input class="form-control form-control" type="date"  id="inicial"  placeholder="Surtir inventario inicial" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Final:</div>
            <div class="col-sm-3">
              <input class="form-control form-control" type="date" id="final" placeholder="Surtir inventario final" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-success btn-block btn-default" onclick="busqueda_surtir()">
                Buscar 
              </button>
            </div>
          </div><br>
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
