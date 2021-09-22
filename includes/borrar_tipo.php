<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  include_once('clase_log.php');
  $herramienta= NEW Herramienta(0);
  $logs = NEW Log(0);
  $herramienta->borrar_herramienta($_POST['id']);
  $logs->guardar_log($_POST['herramienta_id'],"Borrar herramienta: ". $_POST['id']);
?>
