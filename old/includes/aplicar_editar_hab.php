<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_log.php");
  if(empty($_GET['id']) or empty($_GET['nombre']) or empty($_GET['tipo']) or empty($_GET['usuario_id'])){
    echo 'NO_valido';
  }else{
    $hab= NEW Hab(0);
    $logs = NEW Log(0);
    $hab->editar_hab($_GET['id'],urldecode($_GET['nombre']),$_GET['tipo'],urldecode($_GET['comentario']));
    $logs->guardar_log($_GET['usuario_id'],"Editar habitacion: ". $_GET['id']);
  }

?>
