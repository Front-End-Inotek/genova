<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  include_once("clase_log.php");
  if( empty($_GET['id_tipo']) or empty($_GET['nombre']) or empty($_GET['codigo']) or empty($_GET['usuario_id']) ){
    echo 'NO_valido';

  }else{
    $tipo= NEW Tipo(0);
    $logs = NEW Log(0);
    $tipo->editar_tipo($_GET['id_tipo'],urldecode($_GET['nombre']),urldecode($_GET['codigo']));
    $logs->guardar_log($_GET['usuario_id'],"Editar tipo de habitacion: ". $_GET['id_tipo']);
  }




?>
