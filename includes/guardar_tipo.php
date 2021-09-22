<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  include_once('clase_log.php');
  $herramienta= NEW Herramienta(0);
  $logs = NEW Log(0);
  $herramienta->guardar_herramienta(urldecode($_POST['nombre']),urldecode($_POST['marca']),urldecode($_POST['modelo']),urldecode($_POST['descripcion']),$_POST['cantidad_almacen'],$_POST['cantidad_prestadas']);
  $logs->guardar_log($_POST['id'],"Agregar herramienta: ". urldecode($_POST['nombre']));
?>

