<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_cupon.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $cupon= NEW Cupon(0);
  $logs = NEW Log(0);
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

  $reservacion->editar_reservacion($_POST['id'],$_POST['id_huesped'],$_POST['tipo_hab'],$_POST['id_cuenta'],$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['nombre_reserva']),urldecode($_POST['acompanante']),$_POST['forma_pago'],$_POST['limite_pago'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],$_POST['total_hab'],$_POST['forzar_tarifa'],urldecode($_POST['codigo_descuento']),$descuento,$_POST['total'],$_POST['total_pago'],$cantidad_cupon,$tipo_descuento);
  $logs->guardar_log($_POST['usuario_id'],"Editar reservacion: ". $_POST['id']);
?>
