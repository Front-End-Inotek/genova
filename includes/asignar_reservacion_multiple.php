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

  $id_movimiento= $movimiento->disponible_asignar($_POST['id_reservacion'],$_POST['hab_id'],$reservacion->id_huesped,$reservacion->fecha_entrada,$reservacion->fecha_salida,$_POST['usuario_id'],$reservacion->tarifa);
  $mov_actual= $movimiento->ultima_insercion();
  $hab->cambiohab($_POST['hab_id'],$mov_actual,1);
  //$logs->guardar_log($_POST['usuario_id'],"Asignar reservacion ". $_POST['id_reservacion']. " para hacer checkin ".$_POST['hab_id']." en habitacion: ". $hab->nombre); 
  $logs->guardar_log($_POST['usuario_id'],"Asignar reservacion ". $_POST['id_reservacion']. " para hacer checkin en habitacion: ". $hab->nombre); 
  echo $_POST['id_reservacion']."/".$_POST['habitaciones'];

  /*if($_POST['habitaciones'] > 1){
    $habitaciones= $_POST['habitaciones'] - 1;
    echo "<script>";
      echo "select_asignar_reservacion_multiple('$_POST['id_reservacion']','$habitaciones);";
    echo "</script>";
  }*/
?>
