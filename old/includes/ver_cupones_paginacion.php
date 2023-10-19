<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $cupon->mostrar($_GET['posicion'],$_GET['usuario_id']);
  echo  '</div>';
 
  //comentario
?>
