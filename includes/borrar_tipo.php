<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  include_once("clase_log.php");
  $tipo= NEW Tipo(0);
  $logs = NEW Log(0);
  $tipo->borrar_tipo($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar tipo de habitacion: ". $_POST['id']);
?>
