<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $a_buscar= ' ';
  $combinada= 0;
	$reservacion->mostrar_reservacion_por_dia($_GET['dia'],$a_buscar,$combinada,$_GET['id']);
?> 
