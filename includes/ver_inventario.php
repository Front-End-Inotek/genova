<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario(0);
  echo ' <div class="main_container">
          
          <header class="main_container_title">
            <h2>INVENTARIO</h2>
          </header>

          <div class="inputs_form_container justify-content-start">
            <div class="form-floating input_container">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_inventario()" class="form-control custom_input"  autofocus="autofocus" style=" max-width: 380px; " />
              <label for="a_buscar" >Buscar</label>
            </div>
          </div>

          <div id="paginacion_inventario">';
          $cat_paginas = $inventario->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>
          </div>';
  $id_paginacion=1;
  echo '
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_inventario_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }
  echo ' </ul>';
  //comentario
?>
