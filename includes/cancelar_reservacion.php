<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
  $reservacion->modificar_estado($_POST['id'],3);
  $reservacion->modificar_cancelada($_POST['id'],urldecode($_POST['nombre_cancela']));
  $logs->guardar_log($_POST['usuario_id'],"Cancelar reservacion: ". $_POST['id']);

  if($_POST['preasignada']!=0){
    include_once('clase_hab.php');
    $hab = new Hab(0);
    $hab->cambiohabUltimo($_POST['preasignada']);
  }
?>
