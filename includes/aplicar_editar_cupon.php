<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  include_once("clase_log.php");
  $cupon= NEW Cupon(0);
  $logs = NEW Log(0);
  $cupon->editar_cupon($_POST['id'],$_POST['vigencia_inicio'],$_POST['vigencia_fin'],urldecode($_POST['codigo']),urldecode($_POST['descripcion']),$_POST['cantidad'],$_POST['tipo']);
  $logs->guardar_log($_POST['usuario_id'],"Editar cupon: ". $_POST['id']);
?>
