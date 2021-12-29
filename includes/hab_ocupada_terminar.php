<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $estado_interno= $movimiento->mostrar_estado_interno($hab->mov);
  if($estado_interno == 'limpieza'){
    $movimiento->editar_fin_limpieza($hab->mov);
  }else{
    $movimiento->editar_detalle_fin($hab->mov);
  }
  $movimiento->editar_estado_interno($hab->mov,0);
  $logs->guardar_log($_POST['usuario_id'],"Terminar estado interno $estado_interno de la habitacion: ". $hab->nombre);
?>
