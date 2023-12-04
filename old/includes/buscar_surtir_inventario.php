<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
	$inventario = NEW Inventario(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $inventario->buscar_surtir_inventario($a_buscar,$_GET['usuario_id']);
?>