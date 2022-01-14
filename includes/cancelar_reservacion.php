<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
  $reservacion->borrar_reservacion($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar reservacion: ". $_POST['id']);
?>
