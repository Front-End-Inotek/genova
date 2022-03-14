<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $concepto= NEW Concepto(0);
  $logs = NEW Log(0);

  // Cambiar concepto a inactivo
  $concepto->cambiar_activo($_POST['ticket_ini'],$_POST['ticket_fin']);
  // Cambiar ticket a estado 2 (en corte)

  // Guardar corte

  $logs->guardar_log($_POST['usuario_id'],"Hacer corte: ". $_POST['id']);

  
  // cambiar concepto a inactivo, cambiar ticket estado 2, guardar corte reporte
  // hacer reporte, 
  //  $logs->guardar_log($_GET['usuario_id'],"Reporte corte ".$id_reporte.' del '.$dia.' de '.$mes.' de '.$anio); 
  // ver reporte y sacar del sistema
?>
