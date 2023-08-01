<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_cupon.php");
  include_once("clase_log.php");
  include_once('clase_movimiento.php');
  include_once('clase_hab.php');
  $reservacion= NEW Reservacion(0);
  $cupon= NEW Cupon(0);
  $logs = NEW Log(0);
  $hab = new Hab(0);
  $descuento= $_POST['descuento'];
  $tipo_descuento= 0;
  $cantidad_cupon= 0;

  //Revisar la existencia de un cupon de descuento
  // Checar si codigo descuento esta vacio o no
  if (empty($_POST['codigo_descuento'])){
    //echo 'La variable esta vacia';
    $id_cupon=0;
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
        $tipo_descuento= 1;
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

  $pax_extra = isset($_POST['pax_extra']) ? $_POST['pax_extra'] : "";
  $canal_reserva = isset($_POST['canal_reserva']) ? $_POST['canal_reserva'] : "";
  $plan_alimentos = isset($_POST['plan_alimentos']) ? $_POST['plan_alimentos'] : "";
  $tipo_reservacion = isset($_POST['tipo_reservacion']) ? $_POST['tipo_reservacion'] : "";
  $sobrevender = isset($_POST['sobrevender']) ? $_POST['sobrevender'] : "";
  
  //logica para saber si una reservación estará o no garantizada.
  $estado_interno="pendiente";
  if($_POST['estado_tarjeta'] == 2 || !empty($_POST['voucher'] )){
    $estado_interno = "garantizada";
  }
  $total_pago=0;
  if($estado_interno=="garantizada"){
    $total_pago=$_POST['total_pago'];
  }

  $id_reservacion = $reservacion->editar_reservacionNew($_POST['id_huesped'],$_POST['tipo_hab'],0,$_POST['fecha_entrada'],$_POST['fecha_salida'],
  $_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],
  $_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['nombre_reserva']),
  urldecode($_POST['acompanante']),$_POST['forma_pago'],$_POST['limite_pago'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],
  $_POST['total_hab'],$_POST['forzar_tarifa'],urldecode($_POST['codigo_descuento']),$descuento,$_POST['total'],$total_pago,$_POST['hab_id'],
  $_POST['usuario_id'],$cantidad_cupon,$tipo_descuento,$_POST['estado'],$pax_extra,$canal_reserva,$plan_alimentos,$tipo_reservacion,$sobrevender,$_POST['id'],$estado_interno);

  $datos_mov = $reservacion->saber_id_movimiento($_POST['id']);


  if($_POST['forma_pago'] == 2){
    $factuar= 1;
  }else{
    $factuar= 0;
  }



  if(isset($_POST['preasignada']) && $_POST['preasignada']!=0){
    $id_mov = 0;
    if($datos_mov!=null && $datos_mov['motivo'] == "preasignar" && $datos_mov['id_hab']!=0){
        $id_mov=$datos_mov['id'];
        $old_hab = $datos_mov['id_hab'];
        $mov = new Movimiento($id_mov);
        $mov->actualizarHab($id_mov,$_POST['preasignada']);
        $mov->actualizarFechasMov($id_mov, strtotime($_POST['fecha_entrada']),strtotime($_POST['fecha_salida']));
    }

    $hab->cambiohabUltimo($old_hab);
    $hab->cambiohabUltimo($_POST['preasignada']);
  }
  $log_msj="Editar reservacion: ";

  if($datos_mov!=null && $datos_mov['id_hab']!=0){
    $id_mov=$datos_mov['id'];
    $old_hab = $datos_mov['id_hab'];
    $mov = new Movimiento($id_mov);
   
    $mov->actualizarFechasMov($id_mov, strtotime($_POST['fecha_entrada']),strtotime($_POST['fecha_salida']));
    $hab->cambiohabUltimo($old_hab);

    $finalizado = $mov->saber_tiempo_finalizado_renta($id_mov);

    if(!empty($finalizado)){
      $hab->cambiohab($datos_mov['id_hab'],$id_mov,1);
      $log_msj="Reactivar checkin: ";
      $mov->cambiar_finalizado($id_mov);
      if($total_pago>0){
        $descripcion="Pago en checkin";
        $pago_total=$total_pago;
        $fecha_entrada = time();
        $reservacion->ingresar_cuenta($_POST['usuario_id'],$id_mov,$descripcion,$_POST['forma_pago'],$pago_total);

        $cantidad=1;
        $tipo_cargo=3;
        $resta= 0;
        $nombre_concepto="Pago al ingresar";
        $categoria= $actual_hab;
        $nueva_etiqueta= $labels->obtener_etiqueta();
        $labels->actualizar_etiqueta();
        $comanda= $pedido_rest->saber_comanda($id_mov);
        if($_POST['forma_pago'] == 1){
          $efectivo_pago=1;
          $ticket_id= $ticket->guardar_ticket($id_mov,$datos_mov['id_hab'],$_POST['usuario_id'],$_POST['forma_pago'],$total_pago,$total_pago,0,0,0,0,$factuar,'','',$nueva_etiqueta,$resta,$comanda,0);
        }else{
          $efectivo_pago=0;
          $ticket_id= $ticket->guardar_ticket($id_mov,$datos_mov['id_hab'],$_POST['usuario_id'],$_POST['forma_pago'],$total_pago,0,0,$total_pago,0,0,$factuar,'','',$nueva_etiqueta,$resta,$comanda,0);
        }
        $concepto->guardar_concepto($ticket_id,$_POST['usuario_id'],$nombre_concepto,$cantidad,$total_pago,($total_pago*$cantidad),$efectivo_pago,$_POST['forma_pago'],$tipo_cargo,$categoria);
        
        

    }

    }
}

  $logs->guardar_log($_POST['usuario_id'],$log_msj. $_POST['id']);
  echo $_POST['id'];
?>
