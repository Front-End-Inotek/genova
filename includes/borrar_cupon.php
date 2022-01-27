<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  include_once("clase_log.php");
  $cupon= NEW Cupon(0);
  $logs = NEW Log(0);
  $cupon->borrar_cupon($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar cupon: ". $_POST['id']);
?>
