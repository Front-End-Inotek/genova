<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);
  $reservacion->editar_reservacion($_POST['id'],$_POST['id_huesped'],$_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['nombre_reserva']),urldecode($_POST['acompanante']),urldecode($_POST['forma_pago']),$_POST['limite_pago'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],$_POST['total_hab'],$_POST['forzar_tarifa'],$_POST['descuento'],$_POST['total']);
  $logs->guardar_log($_POST['usuario_id'],"Editar reservacion: ". $_POST['id']);
?>
