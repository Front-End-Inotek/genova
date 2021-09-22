<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  include_once('clase_log.php');
  $herramienta= NEW Herramienta(0);
  $logs = NEW Log(0);
  $herramienta->editar_herramienta($_POST['id'],urldecode($_POST['nombre']),urldecode($_POST['marca']),urldecode($_POST['modelo']),urldecode($_POST['descripcion']),$_POST['cantidad_almacen'],$_POST['cantidad_prestadas']);
  $logs->guardar_log($_POST['herramienta_id'],"Editar herramienta: ". $_POST['id']);
?>
