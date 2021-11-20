<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $nombre= $hab->nombre;

  $cuenta->cambiar_hab_cargo($_POST['mov'],$_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Cambiar de habitacion cargo de habitacion: ". $nombre." en cuenta ". $_POST['id']);

  echo $_POST['hab_id']."/".$_POST['estado'];
?>
