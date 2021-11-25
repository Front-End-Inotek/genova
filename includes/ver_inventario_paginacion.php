<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $inventario->mostrar($_GET['posicion'],$_GET['usuario_id']);
  echo  '</div>';
 
  //comentario
?>
