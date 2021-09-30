<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_log.php");
  $huesped= NEW Huesped(0);
  $logs = NEW Log(0);
  $huesped->borrar_huesped($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar huesped: ". $_POST['id']);
?>
