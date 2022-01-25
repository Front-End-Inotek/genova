<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  // Checar si la nota esta vacia o no
  if(empty($_GET['a_buscar'])){
    //echo 'La variable esta vacia';
    $a_buscar= ' ';
    $combinada= 0;
  }else{
    $a_buscar= urldecode($_GET['a_buscar']);
    $combinada= 1;
  }
	$reservacion->mostrar_reservacion_por_dia($_GET['dia'],$a_buscar,$combinada,$_GET['id']);
?>