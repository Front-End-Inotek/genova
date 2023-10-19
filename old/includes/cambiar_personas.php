<?php
  include_once("clase_mesa.php");
  include_once("clase_movimiento.php");
  include_once('clase_log.php');
  $mesa= NEW Mesa($_POST['mesa_id']);
  $movimiento= NEW Movimiento(0);
  $logs = NEW Log(0);
  $movimiento->cambiar_personas($mesa->mov,$_POST['personas']);
  $logs->guardar_log($_POST['usuario_id'],"Cambiar cantidad de personas en mesa: ". $mesa->nombre);
?>
