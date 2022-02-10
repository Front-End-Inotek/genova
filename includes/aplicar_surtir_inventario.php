<?php
	date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_surtir.php");
  $logs = NEW Log(0);
  $surtir = NEW Surtir(0);

  //$surtir->editar_surtir($_POST['id'],$_POST['cantidad']);
  $logs->guardar_log($_POST['usuario_id'],"Aplicar surtir inventario");
?>
