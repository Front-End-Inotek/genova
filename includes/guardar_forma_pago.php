<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  include_once("clase_log.php");
  $forma_pago= NEW Forma_pago(0);
  $logs = NEW Log(0);
  $forma_pago->guardar_forma_pago(urldecode($_POST['descripcion']));
  $logs->guardar_log($_POST['usuario_id'],"Agregar forma de pago: ". urldecode($_POST['descripcion']));
?>

