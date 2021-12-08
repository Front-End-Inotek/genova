<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $movimiento->terminar_mov($hab->mov);
  $hab->cambiohab($_POST['hab_id'],$hab->mov,2);
  $logs->guardar_log($_POST['usuario_id'],"Terminar hospedaje en habitacion: ". $hab->nombre);
?>
