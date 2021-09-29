<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_requisicion.php");
  $requisicion = NEW Requisicion(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $requisicion->buscar_requisicion($a_buscar,$_GET['id']);
?>