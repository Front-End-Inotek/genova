<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_hab.php");
  include_once("clase_cuenta.php");
  include_once("clase_huesped.php");
  include_once("clase_movimiento.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion($_POST['id_reservacion']);
  $hab = NEW Hab($_POST['hab_id']);

  //verificar que la habitación no está ocupada desde una preasignada.
  if($hab->estado!=0){
    echo "OCUPADA";
    die();
  }
  $cuenta = NEW Cuenta(0);
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
 
  //proceso para asignar reservacion a hab si es 'preasignada'
  if(isset($_POST['movimiento']) && !empty($_POST['movimiento'])){
    $mov_actual= $_POST['movimiento'];
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
   
  }else{
    $id_movimiento= $movimiento->disponible_asignar($_POST['id_reservacion'],$_POST['hab_id'],$reservacion->id_huesped,$reservacion->fecha_entrada,$reservacion->fecha_salida,$_POST['usuario_id'],$reservacion->tarifa);
    $mov_actual= $movimiento->ultima_insercion();
    $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
  }

  $reservacion->modificar_estado($_POST['id_reservacion'],2); 
  //Funcion que guarda como abono el total de la cuenta.
  // $id_cuenta= $cuenta->reservacion_cuenta($_POST['usuario_id'],$mov_actual,$reservacion->forma_pago,$reservacion->total_suplementos,$reservacion->total_pago);
  $reservacion->modificar_id_cuenta($_POST['id_reservacion'],$id_cuenta);
  $noches= $reservacion->noches;
  $cantidad_hab= $reservacion->numero_hab;
  $visitas_actuales= $huesped->visitas;
  $visitas= $noches * $cantidad_hab;
  $cantidad_visitas= $visitas_actuales + $visitas;
  $huesped->modificar_visitas($reservacion->id_huesped,$cantidad_visitas);
  $logs->guardar_log($_POST['usuario_id'],"Asignar reservacion ". $_POST['id_reservacion']. " para hacer check-in en habitacion: ". $hab->nombre); 
  echo $_POST['id_reservacion']."/".$_POST['habitaciones'];
?>
