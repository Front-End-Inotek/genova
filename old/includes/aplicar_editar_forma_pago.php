<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  include_once("clase_log.php");
  $forma_pago= NEW Forma_pago(0);
  $logs = NEW Log(0);
  $forma_pago->editar_forma_pago($_POST['id'],urldecode($_POST['descripcion']),urldecode($_POST['garantia']));
  $logs->guardar_log($_POST['usuario_id'],"Editar forma de pago: ". $_POST['id']);
?>
