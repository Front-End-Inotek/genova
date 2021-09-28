<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_log.php");
  $hab= NEW Hab(0);
  $logs = NEW Log(0);
  $hab->editar_hab($_POST['id'],urldecode($_POST['nombre']),$_POST['tipo'],urldecode($_POST['comentario']));
  $logs->guardar_log($_POST['usuario_id'],"Editar habitacion: ". $_POST['id']);
?>
