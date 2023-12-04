<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta_maestra.php");
  include_once("clase_log.php");
  if( empty($_GET['id_tipo']) or empty($_GET['nombre']) or empty($_GET['codigo']) or empty($_GET['usuario_id']) ){
    echo 'NO_valido';

  }else{
    $cm= NEW CuentaMaestra(0);
    $logs = NEW Log(0);
    $cm->editar_cuenta_maestra($_GET['id_tipo'],urldecode($_GET['nombre']),urldecode($_GET['codigo']));
    $logs->guardar_log($_GET['usuario_id'],"Editar cuenta maestra: ". $_GET['id_tipo']);
  }

?>
