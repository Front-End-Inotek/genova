<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
  $reservacion->modificar_estado($_POST['id'],3);
  $logs->guardar_log($_POST['usuario_id'],"Cancelar reservacion: ". $_POST['id']);
?>
