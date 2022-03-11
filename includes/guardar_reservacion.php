<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_cupon.php");
  include_once("clase_hab.php");
  include_once("clase_movimiento.php");
  include_once("clase_ticket.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion(0);
  $concepto= NEW Concepto(0);
  $cupon= NEW Cupon(0);
  $hab = NEW Hab($_POST['hab_id']);
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
  $cuenta= 0;
  if($_POST['forzar_tarifa'] > 0 || $_POST['total_suplementos'] > 0 || $_POST['total_pago'] > 0 || $cantidad_cupon > 0){
    $cuenta= 1;
  }
  
  if($_POST['hab_id'] != 0){
    $id_movimiento= $movimiento->disponible_asignar($hab->mov,$_POST['hab_id'],$_POST['id_huesped'],$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['usuario_id'],$_POST['tarifa']);
    $mov_actual= $movimiento->ultima_insercion();
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
    $logs->guardar_log($_POST['usuario_id'],"Checkin en habitacion: ". $hab->nombre);
    $cuenta= 1;
  }
  $reservacion->guardar_reservacion($_POST['id_huesped'],$_POST['tipo_hab'],$id_movimiento,$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['nombre_reserva']),urldecode($_POST['acompanante']),$_POST['forma_pago'],$_POST['limite_pago'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],$_POST['total_hab'],$_POST['forzar_tarifa'],urldecode($_POST['codigo_descuento']),$descuento,$_POST['total'],$_POST['total_pago'],$_POST['hab_id'],$_POST['usuario_id'],$cuenta,$cantidad_cupon,$tipo_descuento);

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

    $nueva_etiqueta= $labels->obtener_etiqueta();
    $labels->actualizar_etiqueta();

    if($_POST['forma_pago'] == 1){
      $ticket_id= $ticket->guardar_ticket($id_movimiento,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['total_pago'],$_POST['total_pago'],0,0,0,$descuento,$factuar,'','',$nueva_etiqueta);
    }else{
      $ticket_id= $ticket->guardar_ticket($id_movimiento,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['total_pago'],0,0,$_POST['total_pago'],0,$descuento,$factuar,'','',$nueva_etiqueta);
    }

    $cantidad= 1;
    $tipo_cargo= 1; // Corresponde al cargo de hospedaje
    $resta= 0;
    $categoria= $hab->id;
    $nombre= $hab->nombre;
    $nombre_concepto= 'Primer abono de habitacion '.$nombre;
    $concepto->guardar_concepto($ticket_id,$nombre_concepto,$cantidad,$_POST['total_pago'],($_POST['total_pago']*$cantidad),$efectivo_pago,$_POST['forma_pago'],$tipo_cargo,$categoria,$resta);
    $logs->guardar_log($_POST['usuario_id'],"Agregar primer abono a la habitacion: ". $nombre);
    $logs->guardar_log($_POST['usuario_id'],"Agregar ticket: ". $ticket_id);
    // Cupon, extra_persona, suplementos, hab_tipo
  }
?>

