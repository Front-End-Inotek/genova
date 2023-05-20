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

  $cuenta->borrar_cuenta($_POST['id'],$descripcion,$monto);
  $logs->guardar_log($_POST['usuario_id'],"Borrar cargo de habitacion: ". $nombre." en cuenta ". $_POST['id']);
  
  echo $_POST['hab_id']."/".$_POST['estado']."/".$_POST['mov']."/".$_POST['id_maestra'];
?>
