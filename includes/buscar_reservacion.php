<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $reservacion->buscar_reservacion($a_buscar,$_GET['usuario_id']);

  // echo $a_buscar;
?>