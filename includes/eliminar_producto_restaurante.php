<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido_rest=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $pedido_rest->eliminar_producto_apedido($_POST['producto']);
  $id_maestra=0;
  if(isset($_POST['id_maestra'])){
    $id_maestra=$_POST['id_maestra'];
  }

  //$pedido->mostar_pedido($_POST['hab_id'],$_POST['estado'],$_POST['mov']);
  //$logs->guardar_log($_POST['usuario_id'],"Eliminar el producto pedido de restaurante: ". $_POST['producto']);
  echo $_POST['categoria']."/".$_POST['hab_id']."/".$_POST['estado']."/".$_POST['mesa']."/".$_POST['mov']."/".$id_maestra;
?>
