<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta_maestra.php");
  include_once("clase_log.php");
  
  if(empty($_GET['nombre']) or empty($_GET['usuario_id']) or (empty($_GET['codigo']))){
    echo 'NO_valido';

  }else{
    $cm= new CuentaMaestra(0);
    $logs = new Log(0);
    $cm->guardar_cuenta_maestra(urldecode($_GET['nombre']),urldecode($_GET['codigo']),urldecode($_GET['usuario_id']));
    $logs->guardar_log($_GET['usuario_id'],"Agregar cuenta maestra: ". urldecode($_GET['nombre']));
  }


?>