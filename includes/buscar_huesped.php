<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $huesped->buscar_huesped($a_buscar,$_GET['usuario_id']);
?>