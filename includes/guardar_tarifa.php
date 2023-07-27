<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_log.php");

  if(empty($_POST['nombre']) or empty($_POST['precio_hospedaje']) or empty($_POST['cantidad_hospedaje']) or empty($_POST['cantidad_maxima']) or empty($_POST['precio_adulto'])  or empty($_POST['tipo']) or empty($_POST['leyenda'])){
    echo 'NO_valido';

  }else{
    $tarifa= new Tarifa(0);
    $logs = new Log(0);
    $tarifa->guardar_tarifa(urldecode($_POST['nombre']), $_POST['precio_hospedaje'], $_POST['cantidad_hospedaje'], $_POST['cantidad_maxima'], $_POST['precio_adulto'], $_POST['precio_junior'], $_POST['precio_infantil'], $_POST['tipo'], urldecode($_POST['leyenda']));
    $logs->guardar_log($_POST['usuario_id'], "Agregar tarifa hospedaje: ". urldecode($_POST['nombre']));
}
?>

