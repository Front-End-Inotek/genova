<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario(0);
  echo ' <div class="container-fluid blanco">
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">USUARIOS</h2></div>
          <div id="paginacion_usuarios">';
          $cat_paginas = $usuario->mostrar(1,$_GET['id']);
  echo '
          </div>
        </div>';
  $id_paginacion=1;
  echo '
  <ul class="pagination">';
  for($i = 1; $i <= $cat_paginas; $i++){
    echo '<li class="page-item"><a class="page-link" href="#" onclick="ver_usuarios_paginacion('.$i.','.$id_paginacion.')">'.$i.'</a></li>';
    $id_paginacion=$id_paginacion+20;
  }
  echo ' </ul>';
  //comentario
?>
