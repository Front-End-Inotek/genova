<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_log.php");
  $tarifa= NEW Tarifa(0);
  $logs = NEW Log(0);
  $tarifa->borrar_tarifa($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar tarifa hospedaje: ". $_POST['id']);
?>
