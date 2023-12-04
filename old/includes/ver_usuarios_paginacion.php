<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $usuario= NEW Usuario(0);

  echo ' <div class="container-fluid">';
          $cat_paginas = $usuario->mostrar($_GET['posicion'],$_GET['id']);
  echo  '</div>';
 
  //comentario
?>
