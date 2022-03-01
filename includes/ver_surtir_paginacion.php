<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_surtir.php");
  $surtir = NEW Surtir(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $surtir->mostrar($_GET['posicion'],$_GET['usuario_id']);
  echo  '</div>';
 
  //comentario
?>
