<?php
include_once("clase_ticket.php");
$ticket= NEW Ticket(0);
$id_ticket= $_POST["id_ticket"];
$ticket->cambiar_no_facturado($id_ticket);

echo 'SI';
?>