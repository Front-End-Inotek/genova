<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $reservacion->guardar_reservacion($_POST['fecha_entrada'],$_POST['fecha_salida'],$_POST['noches'],$_POST['numero_hab'],$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['extra_adulto'],$_POST['extra_junior'],$_POST['extra_infantil'],$_POST['extra_menor'],$_POST['tarifa'],urldecode($_POST['suplementos']),$_POST['total_suplementos'],$_POST['total_hab'],$_POST['forzar_tarifa'],$_POST['total'],$_POST['usuario_id']);
?>

