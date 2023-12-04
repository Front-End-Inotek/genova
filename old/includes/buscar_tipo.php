<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  $herramienta = NEW Herramienta(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $herramienta->buscar($a_buscar,$_GET['id']);
?>