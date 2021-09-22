<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  include_once('clase_log.php');
  $tipo= NEW Tipo(0);
  $logs = NEW Log(0);
  $tipo->guardar_tipo(urldecode($_POST['nombre']));
  $logs->guardar_log($_POST['id'],"Agregar tipo de habitacion: ". urldecode($_POST['nombre']));
?>

