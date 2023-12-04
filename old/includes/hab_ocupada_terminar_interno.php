<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $movimiento->editar_detalle_fin($hab->mov);
  $movimiento->editar_estado_interno($hab->mov,1.1);
  $logs->guardar_log($_POST['usuario_id'],"Habitacion ocupada sucia: ". $hab->nombre);
?>
