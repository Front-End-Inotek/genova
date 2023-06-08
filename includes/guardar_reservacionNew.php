<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_cupon.php");
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_movimiento.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion(0);
  $concepto= NEW Concepto(0);
  $cupon= NEW Cupon(0);
  $hab = NEW Hab($_POST['hab_id']);
  $pedido_rest= NEW Pedido_rest(0);
  $movimiento = NEW Movimiento($hab->mov);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs = NEW Log(0);
  // Checar si descuento esta vacio o no
  if (empty($_POST['descuento'])){
    //echo 'La variable esta vacia';
    $descuento= 0;
  }else{
    $descuento= $_POST['descuento'];
  }
  $tipo_descuento= 0;
  $cantidad_cupon= 0;
  $id_movimiento= 0;




  //Revisar la existencia de un cupon de descuento
  // Checar si codigo descuento esta vacio o no
  if (empty($_POST['codigo_descuento'])){
    //echo 'La variable esta vacia';
    $id_cupon= 0;
  }else{
    $codigo= urldecode($_POST['codigo_descuento']);
    $id_cupon= $cupon->obtengo_id($codigo);
  }
  if($id_cupon > 0){
    $cupon= NEW Cupon($id_cupon);
    $vigencia_inicio= $cupon->vigencia_inicio;
    $vigencia_fin= $cupon->vigencia_fin;
    $fecha_actual= time();
    $fecha_actual= date("d-m-Y",$fecha_actual);
    $fecha_actual= strtotime($fecha_actual);
    if($fecha_actual >= $vigencia_inicio && $fecha_actual <= $vigencia_fin){
      $tipo_cupon= $cupon->tipo;
      if($tipo_cupon == 0){
        $descuento= $cupon->cantidad;
        $tipo_descuento= 1;// Descuento con cupon
      }else{
        $cantidad_cupon= $cupon->cantidad;
      }
    }
  }

  // No se consideran los suplementos
  /*if($_POST['forzar_tarifa'] > 0){
    $total=$_POST['forzar_tarifa']; 
  }else{*/
    if($_POST['descuento'] > 0){
      $descuento_calculo= $_POST['descuento'] / 100;
      $descuento_calculo= 1 - $descuento_calculo;
      $total=$_POST['total_hab'] * $descuento_calculo;
    }else{
      $total=$_POST['total_hab']; 
    }
  //}
  $cuenta= 1;
  if($_POST['forzar_tarifa'] > 0 || $_POST['total_suplementos'] > 0 || $_POST['total_pago'] > 0 || $cantidad_cupon > 0){
    $cuenta= 1;
  }

  $actual_hab=$_POST['hab_id'];

  if(empty($_POST['preasignada'])){
    $motivo ="reservar";
  }else{
    $motivo="preasignar";
    $actual_hab = $_POST['preasignada'];
    
  }

  $motivo = empty($_POST['preasignada']) ? "reservar" : "preasignar";
 
  $sobrevender = isset($_POST['sobrevender']) ? $_POST['sobrevender'] : "";
  $id_movimiento= $movimiento->disponible_asignar($hab->mov,$actual_hab,$_POST['id_huesped'],$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['usuario_id'],$_POST['tarifa'],$motivo);
  $mov_actual= $movimiento->ultima_insercion();
  if($_POST['hab_id'] != 0){
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
    $logs->guardar_log($_POST['usuario_id'],"Check-in en habitacion: ". $hab->nombre);
    $cuenta= 1;
  }

  $pax_extra = isset($_POST['pax_extra']) ? $_POST['pax_extra'] : "";
  $canal_reserva = isset($_POST['canal_reserva']) ? $_POST['canal_reserva'] : "";
  $plan_alimentos = isset($_POST['plan_alimentos']) ? $_POST['plan_alimentos'] : "";
  $tipo_reservacion = isset($_POST['tipo_reservacion']) ? $_POST['tipo_reservacion'] : "";

  //logica para saber si una reservación estará o no garantizada.
  $estado_interno="pendiente";
  if($_POST['estado_tarjeta'] == 2 || !empty($_POST['voucher'] )){
    $estado_interno = "garantizada";
  }

  $id_reservacion = $reservacion->guardar_reservacionNew($_POST['id_huesped'],$_POST['tipo_hab'],$id_movimiento,$_POST['fecha_entrada'],$_POST['fecha_salida'],
  $_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],
  $_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['nombre_reserva']),
  urldecode($_POST['acompanante']),$_POST['forma_pago'],$_POST['limite_pago'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],
  $_POST['total_hab'],$_POST['forzar_tarifa'],urldecode($_POST['codigo_descuento']),$descuento,$_POST['total'],$_POST['total_pago'],$actual_hab,
  $_POST['usuario_id'],$cuenta,$cantidad_cupon,$tipo_descuento,$_POST['estado'],$pax_extra,$canal_reserva,$plan_alimentos,$tipo_reservacion,$sobrevender,$estado_interno);

  

  //si hay preasignada 
  if($_POST['preasignada']!=0){
    $logs->guardar_log($_POST['usuario_id'],"Preasignar reservacion: ". $id_reservacion . " Hab: " . $actual_hab);

    //Para cambiar el ultimo_mov siendo una reservacion.
    $hab->cambiohabUltimo($actual_hab);
  }

  if($_POST['total_pago'] > 0){
    if($_POST['forma_pago'] == 2){
      $factuar= 1;
    }else{
      $factuar= 0;
    }
    if($_POST['forma_pago'] == 1){
      $efectivo_pago= 1;
    }else{
      $efectivo_pago= 0;
    }

    $tipo_cargo= 3; // Corresponde al cargo de hospedaje sin comida
    $resta= 0;
    $nueva_etiqueta= $labels->obtener_etiqueta();
    $labels->actualizar_etiqueta();
    $comanda= $pedido_rest->saber_comanda($mov);

    if($_POST['forma_pago'] == 1){
      $ticket_id= $ticket->guardar_ticket($id_movimiento,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['total_pago'],$_POST['total_pago'],0,0,0,$descuento,$factuar,'','Pago al reservar',$nueva_etiqueta,$resta,$comanda,0);
    }else{
      $ticket_id= $ticket->guardar_ticket($id_movimiento,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['total_pago'],0,0,$_POST['total_pago'],0,$descuento,$factuar,'','Pago al reservar',$nueva_etiqueta,$resta,$comanda,0);
    }

    $cantidad= 1;
    $categoria= $_POST['tipo_hab'];
    $nombre= $hab->nombre;
    if($nombre == 0){
      $nombre_concepto= 'Primer abono de habitacion ';
    }else{
      $nombre_concepto= 'Primer abono de habitacion '.$nombre;
    }
    $concepto->guardar_concepto($ticket_id,$_POST['usuario_id'],$nombre_concepto,$cantidad,$_POST['total_pago'],($_POST['total_pago']*$cantidad),$efectivo_pago,$_POST['forma_pago'],$tipo_cargo,$categoria);
    
    // Imprimir ticket
    if($confi->ticket_restaurante == 0){
      $ticket->cambiar_estado($ticket_id);
    }

    $logs->guardar_log($_POST['usuario_id'],"Agregar primer abono a la habitacion: ". $nombre);
    $logs->guardar_log($_POST['usuario_id'],"Agregar ticket con etiqueta: ". $nueva_etiqueta);
    // Cupon, extra_persona, suplementos, hab_tipo

    //todo salió bien en teoría, retornar el id de la reservacion creada.
    //echo $id_reservacion;
    
  }
  //Aquí en teoría ya se guardo/hizo la reservación y es momento de mandar el correo con el pdf de confirmación
  echo $id_reservacion;

?>

