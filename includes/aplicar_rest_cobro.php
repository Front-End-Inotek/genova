<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $confi= NEW Configuracion();
  $hab= NEW Hab($_POST['hab_id']);
  $inventario= NEW Inventario(0);
  $pedido= NEW Pedido_rest(0);
  $concepto= NEW Concepto(0);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs= NEW Log(0);
  $hab_nombre= $hab->nombre;

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
  
  // Guardamos el ticket del pedido del restaurante
  $tipo_cargo= 2; // Corresponde al cargo de restaurante
  $resta= 1;
  $nueva_etiqueta= $labels->obtener_etiqueta();
  $labels->actualizar_etiqueta();
  $ticket_id= $ticket->guardar_ticket($_POST['mov'],$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$total_final,$total_pago,$cambio,$monto,$descuento,$total_descuento,$factuar,$folio,$comentario,$nueva_etiqueta,$resta);
  $logs->guardar_log($_POST['usuario_id'],"Agregar ticket con etiqueta: ". $nueva_etiqueta);
  
  // Ajustes luego de guardar un ticket y pagarse pedido del restaurante
  $consulta= $pedido->saber_pedido_rest_cobro($_POST['mov']);
  while($fila = mysqli_fetch_array($consulta))
  {
      $nombre= $inventario->obtengo_nombre($fila['id_producto']);
      $precio= $inventario->obtengo_precio($fila['id_producto']);
      $categoria= $inventario->obtengo_categoria($fila['id_producto']);
      $cantidad= $inventario->cantidad_inventario($fila['id_producto']);
      $historial= $inventario->cantidad_historial($fila['id_producto']);
      $cantidad_nueva= $cantidad - $fila['cantidad'];
      $historial_nuevo= $historial + $fila['cantidad'];
      $inventario->editar_cantidad_inventario($fila['id_producto'],$cantidad_nueva);
      $inventario->editar_cantidad_historial($fila['id_producto'],$historial_nuevo);
      $concepto->guardar_concepto($ticket_id,$nombre,$fila['cantidad'],$precio,($precio*$fila['cantidad']),$efectivo_pago,$_POST['forma_pago'],$tipo_cargo,$categoria);
  }

  $pedido->cambiar_estado_pedido_cobro($_POST['mov']);
  // Imprimir ticket
  if($confi->ticket_restaurante == 0){
      $ticket->cambiar_estado($ticket_id);
  }

  // Se guarda dependiendo si se hace el pedido de forma directa o desde una habitacion
  if($_POST['mov'] == 0){
          $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante directo");
  }else{
          $logs->guardar_log($_POST['usuario_id'],"Cobro restaurante en habitacion: ". $hab_nombre);
  }
?>
