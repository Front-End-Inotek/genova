<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);

  echo '
  <div class="main_container">
    <header class="main_container_title">
      <h2>HUESPEDES</h2>
    </header>

    <div class="inputs_form_container justify-content-start">
      <div class="form-floating inputs_container">
        <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_huesped(event)" class="form-control custom_input" />
        <label for="a_buscar">Buscar</label>
      </div>
    </div>

    <div id="paginacion_huespedes">';
          $cat_paginas = $huesped->mostrar(1,$_GET['usuario_id']);
  echo '
          </div>
    </div>
    ';
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
