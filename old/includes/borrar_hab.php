<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_log.php");
  if(empty($_GET['ID']) or empty($_GET['usuario_id'])){
    echo ('NO_valido');
  }else{
    $hab= NEW Hab(0);
    $logs = NEW Log(0);
    $hab->borrar_hab($_GET['ID']);
    $logs->guardar_log($_GET['usuario_id'],"Borrar habitacion: ". $_GET['ID']);
  }

?>
