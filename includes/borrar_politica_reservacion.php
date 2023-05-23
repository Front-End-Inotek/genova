<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_politicas_reservacion.php");
  include_once("clase_log.php");
  $pr= NEW PoliticasReservacion(0);
  $logs = NEW Log(0);
  if(empty($_GET['id_tipo']) or empty($_GET['usuario_id'])){
    echo 'NO_valido';
  }else{
    $pr->borrar_politica_reservacion($_GET['id_tipo']);
    $logs->guardar_log($_GET['usuario_id'],"Borrar política de reservación: ". $_GET['id_tipo']);
  }

?>
