<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $usuario_id =urldecode($_GET['usuario_id']);
  $opcion = urldecode($_GET['opcion']);
  $inicial= urldecode($_GET['inicial']);


  
  $reservacion->buscar_entradas_salidas(0,$usuario_id,$opcion, $inicial, $a_buscar);
?>