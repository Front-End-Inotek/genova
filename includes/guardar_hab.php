<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_log.php");
  $hab= NEW Hab(0);
  $logs = NEW Log(0);
  $hab->guardar_hab(urldecode($_GET['nombre']),$_GET['tipo'],urldecode($_GET['comentario']));
  $logs->guardar_log($_GET['usuario_id'],"Agregar habitacion: ". urldecode($_GET['nombre']));
?>

