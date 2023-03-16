<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_log.php");
  if(empty($_GET['id']) or empty($_GET['usuario_id'])){
    echo 'NO_valido';
  }else{
    $tarifa= NEW Tarifa(0);
    $logs = NEW Log(0);
    $tarifa->borrar_tarifa($_GET['id']);
    $logs->guardar_log($_GET['usuario_id'],"Borrar tarifa hospedaje: ". $_GET['id']);}

?>
