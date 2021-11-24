<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  include_once("clase_log.php");
  $categoria= NEW Categoria(0);
  $logs = NEW Log(0);
  $categoria->editar_categoria($_POST['id'],urldecode($_POST['nombre']));
  $logs->guardar_log($_POST['usuario_id'],"Editar categoria del inventario: ". $_POST['id']);
?>
