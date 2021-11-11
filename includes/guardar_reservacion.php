<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_hab.php");
  include_once("clase_movimiento.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion(0);
  $hab = NEW Hab($_POST['hab_id']);
  $movimiento = NEW Movimiento($hab->mov);
  $logs = NEW Log(0);
  $cambio_id= 0;
  if($_POST['forzar_tarifa']>0){
    $total=$_POST['forzar_tarifa']; 
  }else{// No se consideran los suplementos
    if($_POST['descuento']>0){
      $descuento= $_POST['descuento'] / 100;
      $descuento= 1 - $descuento;
      $total=$_POST['total_hab'] * $descuento;
    }else{
      $total=$_POST['total_hab']; 
    }
  }

  if($_POST['hab_id']!=0){
    $id_movimiento= $movimiento->disponible_asignar($hab->mov,$_POST['hab_id'],$_POST['id_huesped'],$_POST['noches'],$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['usuario_id'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],$_POST['nombre_reserva'],$_POST['descuento'],$total);
    $mov_actual= $movimiento->ultima_insercion();
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
    $logs->guardar_log($_POST['usuario_id'],"Checkin en habitacion: ". $hab->nombre);
  }
  $reservacion->guardar_reservacion($_POST['id_huesped'],$id_movimiento,$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['nombre_reserva']),urldecode($_POST['acompanante']),$_POST['forma_pago'],$_POST['limite_pago'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],$_POST['total_hab'],$_POST['forzar_tarifa'],$_POST['descuento'],$_POST['total'],$_POST['hab_id'],$_POST['usuario_id']);
?>

