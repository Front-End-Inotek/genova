<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  $logs = NEW Log(0);
  $buscar =urldecode($_GET['buscar']);
  $logs->buscar_usuarios_logs($buscar,$_GET['usuario']);
?>
