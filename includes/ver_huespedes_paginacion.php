<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $huesped->mostrar($_GET['posicion'],$_GET['usuario_id']);
  echo  '</div>';
 
  //comentario
?>
