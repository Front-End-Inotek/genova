<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $mov = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $mov->editar_detalle_fin($hab->mov);
  $mov->editar_estado_interno($hab->mov,1.2);
  $logs->guardar_log($_POST['id'],"Habitacion ocupada limpieza: ". $hab->nombre);
?>
