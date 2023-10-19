<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_log.php");
  $config= NEW Configuracion(0);
  $logs = NEW Log(0);
  if(empty($_GET['id_tipo']) or empty($_GET['usuario_id'])){
    echo 'NO_valido';
  }else{
    $config->borrar_plan_alimentacion($_GET['id_tipo']);
    $logs->guardar_log($_GET['usuario_id'],"Borrar plan de alimentacion: ". $_GET['id_tipo']);
  }

?>
