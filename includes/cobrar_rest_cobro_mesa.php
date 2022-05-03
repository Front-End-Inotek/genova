<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_mesa.php");
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $confi= NEW Configuracion();
  $hab= NEW Hab($_POST['hab_id']);
  $inventario= NEW Inventario(0);
  $mesa= NEW Mesa($_POST['hab_id']);
  $pedido_rest= NEW Pedido_rest(0);
  $pedido= NEW Pedido(0);
  $concepto= NEW Concepto(0);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs= NEW Log(0);

  // Cobro de restaurante al momento en la mesa
  if(empty($_POST['comentario'])){
          //echo 'La variable esta vacia';
          $comentario= '';
  }else{
          $comentario= urldecode($_POST['comentario']);
  }
  if(empty($_POST['folio'])){
        //echo 'La variable esta vacia';
        $folio= '';
  }else{
        $folio= urldecode($_POST['folio']);
  }
  if(is_numeric($_POST['total_final'])){
          $total_final=$_POST['total_final'];
  }else{
          $total_final= 0;
  }
  if(is_numeric($_POST['total_pago'])){
          $total_pago=$_POST['total_pago'];
  }else{
          $total_pago= 0;
  }
  if(is_numeric($_POST['cambio'])){
          $cambio=$_POST['cambio'];
  }else{
          $cambio= 0;
  }
  if(is_numeric($_POST['monto'])){
          $monto=$_POST['monto'];
  }else{
          $monto= 0;
  }
  if(is_numeric($_POST['descuento'])){
          $descuento=$_POST['descuento'];
  }else{
          $descuento= 0;
  }
  if(is_numeric($_POST['total_descuento'])){
          $total_descuento=$_POST['total_descuento'];
  }else{
          $total_descuento= 0;
  }
  if($_POST['forma_pago'] == 2){
          $factuar= 1;
  }else{
          $factuar= 0;
  }
  if($_POST['efectivo']>0){
          $efectivo_pago= 1;
  }else{
          $efectivo_pago= 0;
  }
  
  // Actualizamos datos del ticket del pedido_rest del restaurante
  $ticket_id= $ticket->saber_id_ticket($mesa->mov);
  //$total_calculo= $concepto->saber_total_mesa($ticket_id);
  $ticket->cambiar_imprimir_ticket($ticket_id,$total_final);

  // Ajustes luego de guardar un ticket y pagarse pedido del restaurante
  $consulta= $pedido_rest->saber_pedido_rest_cobro($_POST['mov'],0);
  while($fila = mysqli_fetch_array($consulta))
  {
      $cantidad= $inventario->cantidad_inventario($fila['id_producto']);
      // Acomodar el inventario en cantidad e historial
      $historial= $inventario->cantidad_historial($fila['id_producto']);
      $cantidad_nueva= $cantidad - $fila['cantidad'];
      $historial_nuevo= $historial + $fila['cantidad'];
      $inventario->editar_cantidad_inventario($fila['id_producto'],$cantidad_nueva);
      $inventario->editar_cantidad_historial($fila['id_producto'],$historial_nuevo);
  }

  // Se sabe el pedido, editan estados y se imprime
  $id_pedido= $pedido->obtener_pedido($_POST['mov'],$_POST['hab_id'])
  $pagado= 1;
  $pedido_rest->cambiar_estado_pedido_cobro($_POST['mov'],$pagado);
  
  // Imprimir ticket
  if($confi->ticket_restaurante == 0){
      $ticket->cambiar_estado($ticket_id);
  }

  // Se guarda el cobro del pedido de restaurante al momento en la mesa
  $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante en mesa: ". $mesa->nombre);

  /// FINAL A HAB
  // Se guarda el cargo del pedido de restaurante a una habitacion desde una mesa
  $logs->guardar_log($_POST['usuario_id'],"Cargo de cobro restaurante en habitacion: ". $hab->nombre." de la mesa ". $mesa->nombre);
?>
