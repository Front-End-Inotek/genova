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
 
  $id_movimiento= $movimiento->disponible_asignar($hab->mov,$_POST['hab_id'],$_POST['id_huesped'],$_POST['noches'],$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['usuario_id'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],$_POST['nombre_reserva'],$_POST['descuento'],$total,$_POST['total_pago']);
  $mov_actual= $movimiento->ultima_insercion();
  $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
  $logs->guardar_log($_POST['usuario_id'],"Checkin en habitacion: ". $hab->nombre);
  $logs->guardar_log($_GET['usuario_id'],"Asignar reservación para hacer checkin en habitacion: ". $_GET['id']);
?>
