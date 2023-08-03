<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion($_POST['id']);
  $logs = NEW Log(0);
//   $reservacion->modificar_estado($_POST['id'],3);
  $anterior_pago = $reservacion->total_pago;
  $total_pago = $anterior_pago + $_POST['total_pago'];


  $datos_mov =$reservacion->saber_id_movimiento($reservacion->id);

  //Si tiene asignada una hab se cambia el ultimo mov sobre esa hab.
  if($datos_mov!=null && !empty($datos_mov['id_hab'])){
    include_once('clase_hab.php');
    $hab = new Hab(0);
    $hab->cambiohabUltimo($datos_mov['id_hab']);

  }
  $reservacion->modificar_garantizada($_POST['id'],urldecode($_POST['estado_interno']),urldecode($total_pago),urldecode($_POST['forma_garantia']));

  if($_POST['estado_interno']=="garantizada"){
    include_once('clase_cuenta.php');
    $id_cuenta = $reservacion->id_cuenta;
    $cuenta =new Cuenta($id_cuenta);
    $cuenta->guardar_cuenta($_POST['usuario_id'],$cuenta->mov,"Pago al reservar",urldecode($_POST['forma_garantia']),0,urldecode($_POST['total_pago']));
  }
  $logs->guardar_log($_POST['usuario_id'],"Garantizar reservacion: ". $_POST['id']);
?>
