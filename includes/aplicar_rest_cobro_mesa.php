<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_inventario.php");
  include_once("clase_mesa.php");
  include_once("clase_usuario.php");
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $confi= NEW Configuracion();
  $inventario= NEW Inventario(0);
  $pedido_rest= NEW Pedido_rest(0);
  $pedido= NEW Pedido(0);
  $mesa=NEW Mesa($_POST['hab_id']);
  $usuario=NEW Usuario($_POST['usuario_id']); 
  $concepto= NEW Concepto(0);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs= NEW Log(0);
  ////total,hab_id,estado,mov

  if(empty($_POST['comentario'])){
          //echo 'La variable esta vacia';
          $comentario= '';
  }else{
          $comentario= urldecode($_POST['comentario']);
  }

  // Se agrega el pedido
  $id_pedido= $pedido->pedir_rest($usuario->usuario,$_POST['mov'],$comentario,$_POST['hab_id']);
  $pedido_rest->agregar_pedido($id_pedido,$_POST['mov']);

  // Guardamos el ticket del pedido_rest del restaurante
  $tipo_cargo= 2; // Corresponde al cargo de restaurante
  $resta= 1;
  $ticket_id= $ticket->buscar_id_ticket($_POST['mov'],$_POST['hab_id']);// aun no se si poner k este en estado 0(creo) u 1 el ticket CHECAR
  if($ticket_id == 0){
          $nueva_etiqueta= $labels->obtener_etiqueta();
          $labels->actualizar_etiqueta();
          $comanda= $pedido_rest->saber_comanda($_POST['mov']);
          // $_POST['forma_pago'],$total_final,$total_pago,$cambio,$monto,$descuento,$total_descuento,$factuar,$folio,$comentario
          $ticket_id= $ticket->guardar_ticket($_POST['mov'],$_POST['hab_id'],$_POST['usuario_id'],1,0,0,0,0,0,0,0,'',$comentario,$nueva_etiqueta,$resta,$comanda,1);
          $logs->guardar_log($_POST['usuario_id'],"Agregar ticket con etiqueta: ". $nueva_etiqueta);
  }
  
  // Ajustes luego de guardar un ticket y pagarse pedido del restaurante
  $consulta= $pedido_rest->saber_pedido_rest_cobro($_POST['mov'],$_POST['hab_id']);
  while($fila = mysqli_fetch_array($consulta))
  {
      $nombre= $inventario->obtengo_nombre($fila['id_producto']);
      $precio= $inventario->obtengo_precio($fila['id_producto']);
      $categoria= $inventario->obtengo_categoria($fila['id_producto']);
      $cantidad= $inventario->cantidad_inventario($fila['id_producto']);
      // Acomodar el inventario en cantidad e historial
      /*$historial= $inventario->cantidad_historial($fila['id_producto']);
      $cantidad_nueva= $cantidad - $fila['cantidad'];
      $historial_nuevo= $historial + $fila['cantidad'];
      $inventario->editar_cantidad_inventario($fila['id_producto'],$cantidad_nueva);
      $inventario->editar_cantidad_historial($fila['id_producto'],$historial_nuevo);*/
      $concepto->agregar_concepto_ticket($ticket_id,$_POST['usuario_id'],$nombre,$fila['cantidad'],$precio,($precio*$fila['cantidad']),$efectivo_pago,$_POST['forma_pago'],$tipo_cargo,$categoria);
  }

  // Se editan estados y se imprime
  $pagado= 0;
  $pedido_rest->cambiar_estado_pedido_cobro($_POST['mov'],$pagado);
  $pedido->cambiar_estado_pedido($id_pedido);
  $pedido->cambiar_estado($id_pedido);// Se imprime la comanda
  
  // Imprimir ticket
  /*if($confi->ticket_restaurante == 0){
      $ticket->cambiar_estado($ticket_id);
  }*/ //Checar

  // Se guarda dependiendo si se hace el pedido de forma directa o desde una mesa
  $logs->guardar_log($_POST['usuario_id'],"Pedir restaurante en mesa: ". $mesa->nombre);
?>
