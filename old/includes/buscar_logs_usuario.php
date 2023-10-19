<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  $logs = NEW Log(0);
  if($_GET['usuario'] != 0){
    $logs->buscar_usuario($_GET['usuario']);
  }else{
    $inicial= date("y-m-d",$_GET['inicial']);
    $final= date("y-m-d",$_GET['final']);
    $logs->mostrar_logs_tabla($inicial,$final,$_GET['id']);
  }
?>
