<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  include_once("clase_log.php");
  $forma_pago= NEW Forma_pago(0);
  $logs = NEW Log(0);
  $forma_pago->borrar_forma_pago($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar forma de pago: ". $_POST['id']);
?>
