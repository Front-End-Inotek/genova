<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  $herramienta= NEW Herramienta(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $herramienta->mostrar($_GET['posicion'],$_GET['id']);
  echo  '</div>';
 
  //comentario
?>
