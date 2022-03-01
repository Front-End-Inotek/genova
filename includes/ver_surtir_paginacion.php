<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_surtir_inventario.php");
  $surtir_inventario = NEW Surtir_inventario(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $surtir_inventario->mostrar($_GET['posicion'],$_GET['usuario_id']);
  echo  '</div>';
 
  //comentario
?>
