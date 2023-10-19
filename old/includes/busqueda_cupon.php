<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon(0);
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
          $cupon->mostrar_cupon_fecha($_GET['inicial'],$_GET['final'],$_GET['id']);
  echo ' </div>';
?> 
