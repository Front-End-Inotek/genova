<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_log.php");
  if(empty($_POST['nombre']) or empty($_POST['usuario_id']) or (empty($_POST['costo']) && $_POST['costo']!= 0)){
    echo 'NO_valido';
  }else{
    $config= NEW Configuracion(0);
    $logs = NEW Log(0);
    $config->guardar_plan_alimentos(urldecode($_POST['nombre']),urldecode($_POST['costo']),urldecode($_POST['descripcion']));
    $logs->guardar_log($_POST['usuario_id'],"Agregar tipo de habitacion: ". urldecode($_POST['nombre']));
  }

?>