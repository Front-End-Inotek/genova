<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab_vieja = NEW Hab($_POST['hab_id']);
  $hab_nueva = NEW Hab($_POST['nueva_hab_id']);
  $logs = NEW Log(0);
  $movimiento_vieja  = $hab_vieja->mov;
//   print_r($hab_vieja);
//   print_r($hab_nueva);
//   die();

//La antigua habitacion se pone como vacia sucia; su movimiento como 0, el estado 2.
  $hab_vieja->cambiohab($_POST['hab_id'],0,2);
  $hab_nueva->cambiohab($_POST['nueva_hab_id'],$movimiento_vieja,1);
  $movimiento->actualizar_hab($movimiento_vieja,$_POST['nueva_hab_id']);
  $logs->guardar_log($_POST['usuario_id'],"Cambio de habitacion: ". $hab_vieja->nombre. "a habitacion: ".$hab_nueva->nombre );
?>
