<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta_maestra.php");
  include_once("clase_log.php");
  $cm= NEW CuentaMaestra(0);
  $logs = NEW Log(0);
  if(empty($_GET['id_tipo']) or empty($_GET['usuario_id'])){
    echo 'NO_valido';
  }else{
    $cm->cerrar_cuenta_maestra($_GET['id_tipo'], $_GET['mov']);
    $logs->guardar_log($_GET['usuario_id'],"Borrar cuenta maestra: ". $_GET['id_tipo']);
  }

?>
