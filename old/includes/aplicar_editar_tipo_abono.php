<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_log.php");
  if( empty($_POST['id_abono']) or empty($_POST['nombre']) or empty($_POST['usuario_id']) ){
    echo 'NO_valido';

  }else{
    $config= NEW Configuracion(0);
    $logs = NEW Log(0);
    $config->editar_tipo_abono($_POST['id_abono'],urldecode($_POST['nombre']),urldecode($_POST['descripcion']));
    $logs->guardar_log($_POST['usuario_id'],"Editar tipo  de abono: ". $_POST['id_abono']);
  }




?>
