<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_politicas_reservacion.php");
  include_once("clase_log.php");
  
  if(empty($_POST['nombre']) or empty($_POST['usuario_id']) or empty($_POST['codigo']) or empty($_POST['descripcion'])){
    echo 'NO_valido';

  }else{
    $pr= NEW PoliticasReservacion(0);
    $logs = NEW Log(0);
    $pr->guardar_politica_reservacion(urldecode($_POST['nombre']),urldecode($_POST['codigo']),urldecode($_POST['descripcion']));
    $logs->guardar_log($_POST['usuario_id'],"Agregar política de reservación: ". urldecode($_POST['nombre']));
  }


?>