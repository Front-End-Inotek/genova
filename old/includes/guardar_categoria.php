<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  include_once("clase_log.php");
  $categoria = NEW Categoria(0);
  $logs = NEW Log(0);
  $categoria->guardar_categoria(urldecode($_POST['nombre']));
  $logs->guardar_log($_POST['usuario_id'],"Agregar categoria del inventario: ". urldecode($_POST['nombre']));
?>

