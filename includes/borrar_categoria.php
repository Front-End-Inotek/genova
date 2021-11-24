<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  include_once("clase_log.php");
  $categoria= NEW Categoria(0);
  $logs = NEW Log(0);
  $categoria->borrar_categoria($_POST['id']);
  $logs->guardar_log($_POST['usuario_id'],"Borrar categoria del inventario: ". $_POST['id']);
?>
