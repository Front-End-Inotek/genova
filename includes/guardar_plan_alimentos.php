<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_log.php");
  
  if(empty($_GET['nombre']) or empty($_GET['usuario_id']) or (empty($_GET['costo']) && $_GET['costo']!= 0)){
    echo 'NO_valido';

  }else{
    $config= NEW Configuracion(0);
    $logs = NEW Log(0);
    $config->guardar_plan_alimentos(urldecode($_GET['nombre']),urldecode($_GET['costo']));
    $logs->guardar_log($_GET['usuario_id'],"Agregar tipo de habitacion: ". urldecode($_GET['nombre']));
  }


?>