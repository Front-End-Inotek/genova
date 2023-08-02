<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $inicial =urldecode($_GET['inicial']);
  $final =urldecode($_GET['final']);
  $opcion =urldecode($_GET['opcion']);
  $reservacion->buscar_canceladas($a_buscar,$_GET['usuario_id'],$inicial,$opcion,$final);
?>