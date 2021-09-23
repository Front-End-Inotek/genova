<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once('clase_log.php');
  $tarifa= NEW Tarifa(0);
  $logs = NEW Log(0);
  $tarifa->guardar_tarifa(urldecode($_POST['nombre']),$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['precio_persona'],$_POST['tipo']);
  $logs->guardar_log($_POST['usuario_id'],"Agregar tarifa hospedaje: ". urldecode($_POST['nombre']));
?>

