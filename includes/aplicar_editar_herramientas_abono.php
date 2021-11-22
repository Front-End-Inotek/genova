<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_POST['hab_id']);
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
  $nombre= $hab->nombre;

  $cuenta->editar_abono($_POST['id'],$_POST['abono']);
  $logs->guardar_log($_POST['usuario_id'],"Editar abono de habitacion: ". $nombre." en cuenta ". $_POST['id']);
  
  echo $_POST['hab_id']."/".$_POST['estado'];
?>
