<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_log.php");
  if(empty($_GET['id']) or empty($_GET['nombre']) or empty($_GET['precio_hospedaje']) or empty($_GET['cantidad_hospedaje']) or empty($_GET['cantidad_maxima']) or empty($_GET['precio_adulto'])  or empty($_GET['tipo']) or empty($_GET['leyenda']) or empty($_GET['usuario_id'])){
    echo 'NO_valido';
  }else{
    $tarifa= NEW Tarifa(0);
    $logs = NEW Log(0);
    $tarifa->editar_tarifa($_GET['id'],urldecode($_GET['nombre']),$_GET['precio_hospedaje'],$_GET['cantidad_hospedaje'],$_GET['cantidad_maxima'],$_GET['precio_adulto'],/*$_GET['precio_junior'],*/$_GET['precio_infantil'],$_GET['tipo'],urldecode($_GET['leyenda']));
    $logs->guardar_log($_GET['usuario_id'],"Editar tarifa hospedaje: ". $_GET['id']);
  }

?>
