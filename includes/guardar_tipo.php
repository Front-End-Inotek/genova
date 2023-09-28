<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  include_once("clase_log.php");
  if(empty($_GET['nombre']) or empty($_GET['usuario_id']) or empty($_GET['codigo'])){
    echo 'NO_valido';
  }else{
    $tipo= NEW Tipo(0);
    $logs = NEW Log(0);
      $tipo->guardar_tipo(urldecode($_GET['nombre']),urldecode($_GET['codigo']),urldecode($_GET['color']));
      $logs->guardar_log($_GET['usuario_id'],"Agregar tipo de habitacion: ". urldecode($_GET['nombre']));
  }
?>