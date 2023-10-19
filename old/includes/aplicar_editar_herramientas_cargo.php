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
  $mensaje_log="Editar cargo de habitacion: ". $nombre." en cuenta ". $_POST['id'];
  if(isset($_POST['id_maestra']) && !empty($_POST['id_maestra'])){
    require_once('clase_cuenta_maestra.php');
    $cm = new CuentaMaestra($_POST['id_maestra']);
    $mensaje_log="Editar cargo de cuenta maestra: ". $cm->nombre." en cuenta ". $_POST['id'];
  }

  $cuenta->editar_cargo($_POST['id'],$_POST['cargo']);
  $logs->guardar_log($_POST['usuario_id'],$mensaje_log);
  echo $_POST['hab_id']."/".$_POST['estado']."/".$_POST['mov']."/".$_POST['id_maestra'];
?>
