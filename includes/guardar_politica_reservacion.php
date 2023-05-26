<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_politicas_reservacion.php");
  include_once("clase_log.php");
  
  if(empty($_GET['nombre']) or empty($_GET['usuario_id']) or empty($_GET['codigo']) or empty($_GET['descripcion'])){
    echo 'NO_valido';

  }else{
    $pr= NEW PoliticasReservacion(0);
    $logs = NEW Log(0);
    $pr->guardar_politica_reservacion(urldecode($_GET['nombre']),urldecode($_GET['codigo']),urldecode($_GET['descripcion']));
    $logs->guardar_log($_GET['usuario_id'],"Agregar política de reservación: ". urldecode($_GET['nombre']));
  }


?>