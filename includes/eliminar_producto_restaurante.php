<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido_rest=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $pedido_rest->eliminar_producto_apedido($_POST['producto']);
  //$pedido->mostar_pedido($_POST['hab_id'],$_POST['estado'],$_POST['mov']);
  //$logs->guardar_log($_POST['usuario_id'],"Eliminar el producto a restaurante: ". $_POST['producto']);
  echo $_POST['categoria']."/".$_POST['hab_id']."/".$_POST['estado']."/".$_POST['mesa'];
?>
