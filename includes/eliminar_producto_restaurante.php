<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $pedido->eliminar_producto_apedido($_GET['producto']);
  $pedido->mostar_pedido($_GET['hab_id'],$_GET['estado'],$_GET['mov']);
  //$logs->guardar_log($_GET['usuario_id'],"Eliminar el producto a restaurante: ". $_GET['producto']);
?>
