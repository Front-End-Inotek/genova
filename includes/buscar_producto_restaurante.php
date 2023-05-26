<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario(0);
  if(strlen ($_GET['a_buscar'])>0){
    $inventario->mostar_producto_busqueda(urldecode($_GET['a_buscar']),$_GET['hab_id'],$_GET['estado'],$_GET['mov'],$_GET['mesa'],$_GET['id_maestra']);
  }
?>