<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $hab= NEW Hab(0);
  $logs = NEW Log(0);
  $hab->guardar_hab(urldecode($_POST['nombre']),$_POST['tipo'],urldecode($_POST['comentario']));
  $logs->guardar_log($_POST['usuario_id'],"Agregar habitacion: ". urldecode($_POST['nombre']));
?>

