<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_log.php");
  $inventario= NEW Inventario(0);
  $logs = NEW Log(0);
  $inventario->editar_inventario($_POST['id'],urldecode($_POST['nombre']),urldecode($_POST['descripcion']),$_POST['categoria'],$_POST['precio'],$_POST['precio_compra'],$_POST['stock'],$_POST['inventario'],$_POST['bodega_inventario'],$_POST['bodega_stock'],$_POST['clave']);
  $logs->guardar_log($_POST['usuario_id'],"Editar inventario: ". $_POST['id']);
?>
