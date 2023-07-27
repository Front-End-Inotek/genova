<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion($_POST['id']);
  $logs = NEW Log(0);
//   $reservacion->modificar_estado($_POST['id'],3);
  $anterior_pago = $reservacion->total_pago;
  $total_pago = $anterior_pago + $_POST['total_pago'];

  $reservacion->modificar_garantizada($_POST['id'],urldecode($_POST['estado_interno']),urldecode($total_pago),urldecode($_POST['forma_garantia']));

  if($_POST['estado_interno']=="garantizada"){
    include_once('clase_cuenta.php');
    $id_cuenta = $reservacion->id_cuenta;
    $cuenta =new Cuenta($id_cuenta);
    $cuenta->guardar_cuenta($_POST['usuario_id'],$cuenta->mov,"Pago al reservar",urldecode($_POST['forma_garantia']),0,urldecode($_POST['total_pago']));
  }
  $logs->guardar_log($_POST['usuario_id'],"Garantizar reservacion: ". $_POST['id']);
?>
