<?php
  include_once("clase_mesa.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $mesa= NEW Mesa($_POST['mesa_id']);
  $concepto= NEW Concepto(0);
  $ticket= NEW Ticket(0);
  $logs = NEW Log(0);
  $ticket_id= $ticket->saber_id_ticket($mesa->mov);
  $total= $concepto->saber_total_mesa($ticket_id);
  $ticket->cambiar_imprimir_ticket($ticket_id,$total);
  // Imprimir ticket
  $ticket->cambiar_estado($ticket_id);
  $logs->guardar_log($_POST['usuario_id'],"Imprimir ticket de la mesa: ". $mesa->nombre);
?>
