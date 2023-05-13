<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $inicial =urldecode($_GET['inicial']);
  $opcion =urldecode($_GET['opcion']);
  $reservacion->buscar_entradas_salidas($a_buscar,$_GET['usuario_id'],$inicial,$opcion);
?>