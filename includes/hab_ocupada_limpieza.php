<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $movimiento->editar_detalle_fin($hab->mov);
  $movimiento->editar_persona_limpio($hab->mov,$_POST['usuario']);
  if($_POST['estado'] == 1){// En habitacion ocupada-edo.1 
    $movimiento->editar_estado_interno($hab->mov,1.2);
    $logs->guardar_log($_POST['usuario_id'],"Habitacion ocupada limpieza: ". $hab->nombre);
  }else{// En habitacion sucia-edo.2 
    //$movimiento->terminar_mov($hab->mov);
    $hab->cambiohab($_POST['hab_id'],$hab->mov,3);
    $logs->guardar_log($_POST['usuario_id'],"Limpieza en habitacion: ". $hab->nombre);
  }
?>
