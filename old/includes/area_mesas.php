<?php
  date_default_timezone_set('America/Mexico_City');
  include ("informacion_mesas.php");
  $mesas = NEW Informacion_mesas(0);
  $mesas->mostrar_mesas();
  //$mesas->mostrar_mesa($_GET['id'],$_GET['token'],$_GET['categoria']);
?>
