<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_log.php");
  if(empty($_POST['nombre']) or empty($_POST['usuario_id'])){
    echo 'NO_valido';
  }else{
    $pr= NEW Configuracion(0);
    $logs = NEW Log(0);
    $pr->guardar_tipo_abono(urldecode($_POST['nombre']),urldecode($_POST['descripcion']));
    $logs->guardar_log($_POST['usuario_id'],"Agregar tipo de abono: ". urldecode($_POST['nombre']));
  }
?>