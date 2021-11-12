<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $usuario= NEW Usuario(0);
  $logs = NEW Log(0);
  $usuario->borrar_usuario($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar usuario: ". $_POST['id']);
?>
