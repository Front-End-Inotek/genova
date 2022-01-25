<?php
/*
  echo ' <div class="container-fluid">
          <div class="row">';
          $fecha_inicial_dia = substr($_GET['inicial'], 8, 2);
          $fecha_inicial_mes = substr($_GET['inicial'], 5, 2); 
          $fecha_inicial_anio = substr($_GET['inicial'], 0, 4);  
          $fecha_final_dia = substr($_GET['final'], 8, 2);
          $fecha_final_mes = substr($_GET['final'], 5, 2); 
          $fecha_final_anio = substr($_GET['final'], 0, 4);
  echo ' </div>';
          echo ' <h4><p><a href="#" class="text-dark">Buscar del '.$fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio.'</a></p></h4>';
          $reservacion->mostrar_reservacion_fecha($_GET['inicial'],$_GET['final'],$_GET['id']);
  echo ' </div>';*/

  ////

	date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  $fecha_inicial_dia = substr($_GET['inicial'], 8, 2);
  $fecha_inicial_mes = substr($_GET['inicial'], 5, 2); 
  $fecha_inicial_anio = substr($_GET['inicial'], 0, 4);  
  $fecha_final_dia = substr($_GET['final'], 8, 2);
  $fecha_final_mes = substr($_GET['final'], 5, 2); 
  $fecha_final_anio = substr($_GET['final'], 0, 4);
  // Checar si la nota esta vacia o no
  if(empty($_GET['inicial']) && empty($_GET['final'])){
    //echo 'La variable esta vacia';
    echo ' <div class="container-fluid">
      <h4><p><a href="#" class="text-dark"></a></p></h4>';
    echo ' </div>';
  }else{
    echo ' <div class="container-fluid">
      <h4><p><a href="#" class="text-dark">Buscar del '.$fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio.'</a></p></h4>';
    echo ' </div>';
  }

  // Checar si la busqueda esta vacia o no
  if(empty($_GET['a_buscar'])){
    //echo 'La variable esta vacia';
    $a_buscar= ' ';
    $combinada= 0;
  }else{
    $a_buscar= urldecode($_GET['a_buscar']);
    $combinada= 1;
  }
	$reservacion->mostrar_reservacion_fecha($_GET['inicial'],$_GET['final'],$a_buscar,$combinada,$_GET['id']);
?>