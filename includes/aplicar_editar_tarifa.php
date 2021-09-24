<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once('clase_log.php');
  $tarifa= NEW Tarifa(0);
  $logs = NEW Log(0);
  $tarifa->editar_tarifa($_POST['id'],urldecode($_POST['nombre']),$_POST['precio_hospedaje'],$_POST['cantidad_hospedaje'],$_POST['precio_adulto'],$_POST['precio_junior'],$_POST['precio_infantil'],$_POST['tipo'],);
  $logs->guardar_log($_POST['usuario_id'],"Editar tarifa hospedaje: ". $_POST['id']);
?>
