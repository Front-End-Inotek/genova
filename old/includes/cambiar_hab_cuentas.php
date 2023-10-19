<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $nombre= $hab->nombre;

  //$cuenta->cambiar_hab_cuentas($_POST['mov_hab'],$_POST['mov']);
  $logs->guardar_log($_POST['usuario_id'],"Unificar las cuentas de habitacion: ". $nombre."  a la habitacion ". urldecode($_POST['nombre_hab']));

  echo $_POST['hab_id']."/".$_POST['estado'];
  $cuenta->cambiar_hab_cuentas($_POST['mov_hab'],$_POST['mov']);
?>
