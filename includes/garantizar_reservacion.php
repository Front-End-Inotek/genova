<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
//   $reservacion->modificar_estado($_POST['id'],3);


  $reservacion->modificar_garantizada($_POST['id'],urldecode($_POST['estado_interno']),urldecode($_POST['total_pago']),urldecode($_POST['forma_garantia']));
  $logs->guardar_log($_POST['usuario_id'],"Garantizar reservacion: ". $_POST['id']);


?>
