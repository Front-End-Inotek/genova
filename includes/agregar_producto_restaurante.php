<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $hab=NEW Hab(0);
  $pedido=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  if($_GET['hab_id'] == 0){
    $mov= 0;
  }else{
    $mov= $hab->mostrar_mov_hab($_GET['hab_id']);
  }
  $pedido->agregar_producto_apedido($_GET['hab_id'],$_GET['estado'],$_GET['producto'],$mov);// mov 0 x ser sin hab
  $pedido->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov);// mov y hab son 0 al ser sin hab
  //$logs->guardar_log($_GET['usuario_id'],"Asignar el producto a restaurante: ". $_GET['producto']);
?>

