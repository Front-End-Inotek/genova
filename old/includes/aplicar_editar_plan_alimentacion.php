<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_log.php");
  if( empty($_GET['id_tipo']) or empty($_GET['nombre']) or empty($_GET['costo']) or empty($_GET['usuario_id']) ){
    echo 'NO_valido';

  }else{
    $config= NEW Configuracion(0);
    $logs = NEW Log(0);
    $config->editar_plan($_GET['id_tipo'],urldecode($_GET['nombre']),urldecode($_GET['costo']));
    $logs->guardar_log($_GET['usuario_id'],"Editar plan de alimentación: ". $_GET['id_tipo']);
  }




?>
