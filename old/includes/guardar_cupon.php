<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon(0);
  $cupon->guardar_cupon($_POST['vigencia_inicio'],$_POST['vigencia_fin'],urldecode($_POST['codigo']),urldecode($_POST['descripcion']),$_POST['cantidad'],$_POST['tipo'],$_POST['usuario_id']);
?>

