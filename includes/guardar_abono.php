<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $mov= $hab->mov;
  $nombre= $hab->nombre;
  //$_POST['faltante']
  $faltante= 0;
  $cuenta->guardar_cuenta($_POST['usuario_id'],$mov,urldecode($_POST['descripcion']),$_POST['forma_pago'],$faltante,$_POST['abono']);
  $logs->guardar_log($_POST['usuario_id'],"Agregar abono a la habitacion: ". $nombre);
  echo $_POST['hab_id']."/".$_POST['estado'];
?>
