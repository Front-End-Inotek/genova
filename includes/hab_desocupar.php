<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  $movimiento->desocupar_mov($hab->mov);
  $hab->cambiohab($_POST['hab_id'],$hab->mov,2);
  if(isset($_POST['ver']) && $_POST['ver'] !=0){
    $logs->guardar_log($_POST['usuario_id'],"Terminar uso casa en habitación: ". $hab->nombre);
  }else{
    $logs->guardar_log($_POST['usuario_id'],"Terminar hospedaje en habitación: ". $hab->nombre);
  }

?>
