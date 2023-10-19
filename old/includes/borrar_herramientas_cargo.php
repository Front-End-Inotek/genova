<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta($_POST['id']);
  $hab= NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $descripcion= $cuenta->descripcion;
  $nombre= $hab->nombre;
  $monto= 1;
  $mensaje_log="Borrar cargo de habitacion: ". $nombre." en cuenta ". $_POST['id'];
  if(isset($_POST['id_maestra']) && !empty($_POST['id_maestra'])){
    require_once('clase_cuenta_maestra.php');
    $cm = new CuentaMaestra($_POST['id_maestra']);
    $mensaje_log="Borrar cargo de cuenta maestra: ". $cm->nombre." en cuenta ". $_POST['id'];
  }

  $cuenta->borrar_cuenta($_POST['id'],$descripcion,$monto);
  $logs->guardar_log($_POST['usuario_id'],$mensaje_log);
  
  echo $_POST['hab_id']."/".$_POST['estado']."/".$_POST['mov']."/".$_POST['id_maestra'];
?>
