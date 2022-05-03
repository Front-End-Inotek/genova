<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $confi= NEW Configuracion(0);//? o vacio
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_POST['hab_id']);
  $inventario= NEW Inventario(0);
  $pedido_rest= NEW Pedido_rest(0);
  $pedido= NEW Pedido(0);
  $concepto= NEW Concepto(0);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs= NEW Log(0);
  
  // Cobro de restaurante en hab con el total como cargo a la habitacion
  $comentario= '';
  $folio= '';
  $total_final= $_POST['total'];
  $total_pago= 0;
  $cambio= 0;
  $monto= 0;
  $descuento= 0;
  $total_descuento= 0;
  $factuar= 0;
  $forma_pago= 1;
  $efectivo_pago= 0;

  // Se agrega el pedido
  $id_pedido= $pedido->pedir_rest($usuario->nombre,$_POST['mov'],$comentario,$hab->nombre);
  $pedido_rest->agregar_pedido($id_pedido,$_POST['mov']);
  
  // Guardamos el ticket del pedido_rest del restaurante
  $tipo_cargo= 2; // Corresponde al cargo de restaurante
  $resta= 1;
  /*$ticket_id= $ticket->buscar_id_ticket($_POST['mov'],$_POST['hab_id']);// aun no se si poner k este en estado 0 u 1 el ticket CHECAR
  if($ticket_id == 0){
  }*/ // DUDA DE SI SE VA GUARDAR TICKET NUEVO O NO EN HAB
  $nueva_etiqueta= $labels->obtener_etiqueta();
  $labels->actualizar_etiqueta();
  $comanda= $pedido_rest->saber_comanda($_POST['mov']);
  $ticket_id= $ticket->guardar_ticket($_POST['mov'],$_POST['hab_id'],$_POST['usuario_id'],$forma_pago,$total_final,$total_pago,$cambio,$monto,$descuento,$total_descuento,$factuar,$folio,$comentario,$nueva_etiqueta,$resta,$comanda,0);
  $logs->guardar_log($_POST['usuario_id'],"Agregar ticket con etiqueta: ". $nueva_etiqueta);
  
  // Ajustes luego de guardar un ticket y pagarse pedido del restaurante
  $consulta= $pedido_rest->saber_pedido_rest_cobro($_POST['mov'],0);
  while($fila = mysqli_fetch_array($consulta))
  {
      $nombre= $inventario->obtengo_nombre($fila['id_producto']);
      $precio= $inventario->obtengo_precio($fila['id_producto']);
      $categoria= $inventario->obtengo_categoria($fila['id_producto']);
      $cantidad= $inventario->cantidad_inventario($fila['id_producto']);
      // Acomodar el inventario en cantidad e historial
      $historial= $inventario->cantidad_historial($fila['id_producto']);
      $cantidad_nueva= $cantidad - $fila['cantidad'];
      $historial_nuevo= $historial + $fila['cantidad'];
      $inventario->editar_cantidad_inventario($fila['id_producto'],$cantidad_nueva);
      $inventario->editar_cantidad_historial($fila['id_producto'],$historial_nuevo);
      $concepto->guardar_concepto($ticket_id,$_POST['usuario_id'],$nombre,$fila['cantidad'],$precio,($precio*$fila['cantidad']),$efectivo_pago,$forma_pago,$tipo_cargo,$categoria);
  }

  // Se editan estados y se imprime
  $pagado= 0;
  $pedido_rest->cambiar_estado_pedido_cobro($_POST['mov'],$pagado);
  $pedido->cambiar_estado_pedido($id_pedido);
  $pedido->cambiar_estado($id_pedido);// Se imprime la comanda
  
  // Guardar el cargo total del restaurante de la habitacion
  $descripcion= 'Restaurante';
  $cargo= $_POST['total'];
  $cuenta->guardar_cuenta($_POST['usuario_id'],$_POST['mov'],$descripcion,$forma_pago,$cargo,0);
  
  // Imprimir ticket
  if($confi->ticket_restaurante == 0){
      $ticket->cambiar_estado($ticket_id);
  }

  // Se guarda el cargo del pedido de restaurante desde una habitacion
  $logs->guardar_log($_POST['usuario_id'],"Cargo de cobro restaurante en habitacion: ". $hab->nombre);
?>
