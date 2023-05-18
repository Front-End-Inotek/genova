<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta_maestra.php");
  include_once("clase_log.php");

  if(empty($_POST['huesped']) or empty($_POST['id_maestra']) or empty($_POST['mov'])){
    echo 'NO_valido';

  }else{
    $cm= NEW CuentaMaestra(0);
    $logs = NEW Log(0);
    $cm->guardar_huesped_maestra(urldecode($_POST['huesped']),urldecode($_POST['id_maestra']),urldecode($_POST['mov']));
    $logs->guardar_log($_POST['usuario_id'],"Agregar huesped ".urldecode($_POST['id_maestra'])." a cuenta maestra: ". urldecode($_POST['id_maestra']));
  }


?>