<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $pedido->agregar_producto_apedido(0,$_GET['producto']);// mov 0 x ser sin hab
  $pedido->mostar_pedido_directo(0,0);// mov y hab son 0 al ser sin hab
  //$logs->guardar_log($_GET['id'],"Asignar el producto a restaurante: ". $_GET['producto']);
?>

