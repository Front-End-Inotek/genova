<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_hab.php");
  include_once("clase_movimiento.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion($_POST['id_reservacion']);
  $hab = NEW Hab($_POST['hab_id']);
  $movimiento = NEW Movimiento($hab->mov);
  $logs = NEW Log(0);
  $cambio_id= 0;
  if($reservacion->forzar_tarifa > 0){
    $total= $reservacion->forzar_tarifa; 
  }else{// No se consideran los suplementos
    if($reservacion->descuento > 0){
      $descuento= $reservacion->descuento;
      $descuento= $descuento / 100;
      $descuento= 1 - $descuento;
      $total= $reservacion->total_hab * $descuento;
    }else{
      $total= $reservacion->total_hab; 
    }
  }
 
  $id_movimiento= $movimiento->disponible_asignar($hab->mov,$_POST['hab_id'],$reservacion->id_huesped,$reservacion->noches,$reservacion->fecha_entrada,$reservacion->fecha_salida,$_POST['usuario_id'],$reservacion->extra_adulto,$reservacion->extra_junior,$reservacion->extra_infantil,$reservacion->extra_menor,$reservacion->tarifa,$reservacion->nombre_reserva,$reservacion->descuento,$total,$reservacion->total_pago);
  $mov_actual= $movimiento->ultima_insercion();
  $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
  $logs->guardar_log($_GET['usuario_id'],"Asignar reservación ". $_POST['id_reservacion']. " para hacer checkin en habitacion: ". $hab->nombre);  
  //++visita
?>
