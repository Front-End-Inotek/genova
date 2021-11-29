<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $pedido=NEW Pedido_rest(0);
  sleep(1);
  $pedido->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado']);
?>

