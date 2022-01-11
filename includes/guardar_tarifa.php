<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_log.php");
  $tarifa= NEW Tarifa(0);
  $logs = NEW Log(0);
  $tarifa->guardar_tarifa(urldecode($_POST['nombre']),$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['cantidad_maxima'],$_POST['precio_adulto'],$_POST['precio_junior'],$_POST['precio_infantil'],$_POST['tipo'],urldecode($_POST['leyenda']));
  $logs->guardar_log($_POST['usuario_id'],"Agregar tarifa hospedaje: ". urldecode($_POST['nombre']));
?>

