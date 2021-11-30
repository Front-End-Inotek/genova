<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $hab= NEW habitacion($_POST['hab_id']);
  $inventario = NEW Inventario(0);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs= NEW Log(0);
  $hab_nombre= $hab->nombre;
  
  if(is_numeric($_POST['total_final'])){
        $total_final=$_POST['total_final'];
  }else{
        $total_final=0;
  }
  if(is_numeric($_POST['total_pago'])){
          $total_pago=$_POST['total_pago'];
  }else{
          $total_pago=0;
  }
  if(is_numeric($_POST['cambio'])){
          $cambio=$_POST['cambio'];
  }else{
          $cambio=0;
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
  if(is_numeric($_POST['total_descuento'])){
        $total_descuento=$_POST['total_descuento'];
  }else{
        $total_descuento=0;
  }
  if($_POST['forma_pago'] == 2){
    $factuar=1;
  }else{
    $factuar=0;
  }
  

  $nueva_etiqueta= $labels->obtener_etiqueta();
  $labels->actualizar_etiqueta();
  $ticket_id= $ticket->guardar_ticket($_POST['mov'],$_POST['hab_id'],$_POST['usuario_id'],0,$_POST['forma_pago'],$total_final,$total_pago,$cambio,$monto,$descuento,$total_descuento,$factuar,$_POST['folio'],$nueva_etiqueta);
  

  //NO OLVIDAR $_POST['comentario']--urldecode($_POST['comentario'])

  // Se guarda dependiendo si se hace el pedido de forma directa o desde una habitacion
  /*if($_POST['mov'] == 0){
          $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante directo");
  }else{
          $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante en habitacion: ". $hab_nombre);
  }*/
?>
