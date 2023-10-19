<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
  $result = $reservacion->preasignar_hab($_POST['id'],urldecode($_POST['preasignada']));
  if($result=="BIEN"){
  
    include_once('clase_hab.php');
    $hab = new Hab(0);
    $hab->cambiohabUltimo($_POST['preasignada']);
    echo "BIEN";
  }

  $logs->guardar_log($_POST['usuario_id'],"Preasginar reservacion: ". $_POST['id'] . " Hab:" . $_POST['preasignada']);
?>
