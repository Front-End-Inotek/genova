<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_log.php");
  $inventario= NEW Inventario(0);
  $logs = NEW Log(0);
  $inventario->borrar_inventario($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar inventario: ". $_POST['id']);
?>
