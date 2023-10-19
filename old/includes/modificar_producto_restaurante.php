<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido_rest=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $pedido_rest->editar_producto_apedido($_POST['producto'],$_POST['cantidad']);
  //$pedido->mostar_pedido($_POST['hab_id'],$_POST['estado'],$_POST['mov']);
  //$logs->guardar_log($_POST['usuario_id'],"Eliminar el producto pedido de restaurante: ". $_POST['producto']);
  echo $_POST['categoria']."/".$_POST['hab_id']."/".$_POST['estado']."/".$_POST['mesa']."/".$_POST['mov']."/".$_POST['id_maestra'];
?>
