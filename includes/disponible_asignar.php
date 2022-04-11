<?php
  include_once("clase_movimiento.php");
  include_once("clase_mesa.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $movimiento= NEW Movimiento(0);
  $mesa= NEW Mesa($_POST['mesa_id']);
  $ticket= NEW Ticket(0);
  $logs = NEW Log(0);
  if($_POST['mesa_id'] != 0){
    $id_movimiento= $movimiento->mesa_asignar($_POST['mesa_id'],$_POST['usuario_id'],$_POST['personas']);
    $mesa->cambiomesa($_POST['mesa_id'],$id_movimiento,1);
    //$ticket_id= $ticket->guardar_ticket($id_movimiento,$_POST['mesa_id'],$_POST['usuario_id'],$_POST['usuario_id'],0,0,0,0,0,0,0,0,1,0,0);
    $logs->guardar_log($_POST['usuario_id'],"Asignar mesa: ". $mesa->nombre);
  }
?>
