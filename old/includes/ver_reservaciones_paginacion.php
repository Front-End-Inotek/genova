<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $cat_paginas=0;
  $inicial=$_GET['inicial'];
  $a_buscar="";
  $final =$_GET['final'];
  // echo $_GET['caso'];
  switch($_GET['caso']){
    case "1":
    case "2":
    case "4":
      $cat_paginas = $reservacion->mostrar_reportes_reservas(1,$_GET['usuario_id'],$_GET['caso'],$inicial,$a_buscar);
    break;
    case "11":
      $cat_paginas=$reservacion->mostrar_llegadas($_GET['posicion'],$_GET['usuario_id']);
    break;
    case "12":
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
