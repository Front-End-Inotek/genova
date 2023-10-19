<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario=NEW Inventario(0);
  $inventario->mostrar_producto_restaurente($_GET['categoria'],$_GET['hab_id'],$_GET['estado'],$_GET['mov'],$_GET['mesa'],$_GET['maestra']);
  //echo "Mostrando busqueda de restaurante ".$_GET['categoria'];
?>
