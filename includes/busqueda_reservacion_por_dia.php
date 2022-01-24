<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
	$reservacion->mostrar_reservacion_por_dia($_GET['dia'],$_GET['id']);
?> 
