<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $cupon->buscar_cupon($a_buscar,$_GET['usuario_id']);
?>