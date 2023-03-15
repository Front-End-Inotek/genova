<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_log.php");

  if(empty($_GET['nombre']) or empty($_GET['precio_hospedaje']) or empty($_GET['cantidad_hospedaje']) or empty($_GET['cantidad_maxima']) or empty($_GET['precio_adulto']) or empty($_GET['precio_junior']) or empty($_GET['precio_infantil']) or empty($_GET['tipo']) or empty($_GET['leyenda'])){
    echo 'NO_valido';

  }else{
    $tarifa= new Tarifa(0);
    $logs = new Log(0);
    $tarifa->guardar_tarifa(urldecode($_GET['nombre']), $_GET['precio_hospedaje'], $_GET['cantidad_hospedaje'], $_GET['cantidad_maxima'], $_GET['precio_adulto'], $_GET['precio_junior'], $_GET['precio_infantil'], $_GET['tipo'], urldecode($_GET['leyenda']));
    $logs->guardar_log($_GET['usuario_id'], "Agregar tarifa hospedaje: ". urldecode($_GET['nombre']));
}
?>

