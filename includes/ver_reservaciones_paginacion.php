<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $cat_paginas=0;

  switch($_GET['caso']){
    case "2":
      $cat_paginas=$reservacion->mostrar_salidas($_GET['posicion'],$_GET['usuario_id']);
    break;
    default:
      $cat_paginas = $reservacion->mostrar($_GET['posicion'],$_GET['usuario_id']);
  }

  echo ' <div class="container-fluid">';
          $cat_paginas;
  echo  '</div>';

  //comentario
?>
