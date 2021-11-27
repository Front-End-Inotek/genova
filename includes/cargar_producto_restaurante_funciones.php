<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $pedido->mostar_pedido_directo_funciones(0,0);
  //$logs->guardar_log($_GET['id'],"Asignar el producto a restaurante: ". $_GET['producto']);
?>

