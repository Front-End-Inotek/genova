<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $hab= NEW habitacion($_POST['hab_id']);
  $inventario = NEW Inventario(0);
  $ticket= NEW Ticket(0);
  $logs= NEW Log(0);
  $hab_nombre= $hab->nombre;
  
  if(is_numeric($_POST['efectivo'])){
          $efectivo=$_POST['efectivo'];
  }else{
          $efectivo=0;
  }
  if(is_numeric($_POST['monto'])){
          $monto=$_POST['monto'];
  }else{
          $monto=0;
  }
  if(is_numeric($_POST['descuento'])){
          $descuento=$_POST['descuento'];
  }else{
          $descuento=0;
  }
  $factuar=0;
  if($_POST['forma_pago'] == 2){
    $factuar=1;
  }

  //$ticket_id=$ticket->guardar_ticket(0,0,$_POST['id'],0,$_POST['total'],$efectivo,$_POST['cambio'],$tarjeta,$descuento,0,$_POST['autoriza'],1,0,$factuar);
  

  // Se guarda dependiendo si se hace el pedido de forma directa o desde una habitacion
  /*if($_POST['mov'] == 0){
          $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante directo");
  }else{
          $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante en habitacion: ". $hab_nombre);
  }*/
?>
