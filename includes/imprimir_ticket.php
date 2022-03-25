<?php
  include_once("clase_mesa.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $mesa= NEW Mesa($_POST['mesa_id']);
  $ticket= NEW Ticket(0);
  $logs = NEW Log(0);
  
  $ticket_id= $ticket->saber_id_ticket($mesa->mov);
  $total= $ticket->saber_total_mesa($ticket_id);
  $ticket->cambiar_imprimir_ticket($ticket_id,$total);
  $ticket->cambiar_estado($ticket_id);
  $logs->guardar_log($_POST['usuario_id'],"Imprimir ticket de la mesa: ". $mesa->nombre);
?>
