<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once("clase_movimiento.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion($_POST['id_reservacion']);
  $hab = NEW Hab($_POST['hab_id']);
  $huesped = NEW Huesped($reservacion->id_huesped);
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
 
  if($_POST['hab_id'] == 1){
    $id_movimiento= $movimiento->disponible_asignar($_POST['id_reservacion'],$_POST['hab_id'],$reservacion->id_huesped,$reservacion->noches,$reservacion->fecha_entrada,$reservacion->fecha_salida,$_POST['usuario_id'],$reservacion->extra_adulto,$reservacion->extra_junior,$reservacion->extra_infantil,$reservacion->extra_menor,$reservacion->tarifa,$reservacion->nombre_reserva,$reservacion->descuento,$total,$reservacion->total_pago);
    $mov_actual= $movimiento->ultima_insercion();
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
    $reservacion->modificar_estado($_POST['id_reservacion'],2); 
    $noches= $reservacion->noches;
    $cantidad_hab= $reservacion->numero_hab;
    $visitas_actuales= $huesped->visitas;
    $visitas= $noches * $cantidad_hab;
    $cantidad_visitas= $visitas_actuales + $visitas;
    $huesped->modificar_visitas($reservacion->id_huesped,$cantidad_visitas);
    $logs->guardar_log($_POST['usuario_id'],"Asignar reservacion ". $_POST['id_reservacion']. " para hacer checkin en habitacion: ". $hab->nombre); 
  }else{
    $id_movimiento= $movimiento->disponible_asignar($_POST['id_reservacion'],$_POST['hab_id'],$reservacion->id_huesped,$reservacion->noches,$reservacion->fecha_entrada,$reservacion->fecha_salida,$_POST['usuario_id'],$reservacion->extra_adulto,$reservacion->extra_junior,$reservacion->extra_infantil,$reservacion->extra_menor,$reservacion->tarifa,$reservacion->nombre_reserva,$reservacion->descuento,0);
    $mov_actual= $movimiento->ultima_insercion();
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
    $logs->guardar_log($_POST['usuario_id'],"Asignar reservacion ". $_POST['id_reservacion']. " para hacer checkin ".$_POST['hab_id']." en habitacion: ". $hab->nombre); 
  }

  if($_POST['hab_id'] > 1){
    $habitaciones= $_POST['hab_id'] - 1;
    echo "<script>";
      echo "select_asignar_reservacion_multiple('$_POST['id_reservacion']','$habitaciones);";
    echo "</script>";
  }
?>
