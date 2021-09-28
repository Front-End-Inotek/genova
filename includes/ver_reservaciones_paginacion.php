<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $reservacion->mostrar($_GET['posicion'],$_GET['usuario_id']);
  echo  '</div>';
 
  //comentario
?>
