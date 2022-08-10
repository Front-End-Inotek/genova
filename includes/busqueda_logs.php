<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  $logs = NEW Log(0);

  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">LOGS</h2></div>
          
          <div class="row"';
          $fecha_inicial_dia = substr($_GET['inicial'], 8, 2);
          $fecha_inicial_mes = substr($_GET['inicial'], 5, 2); 
          $fecha_inicial_anio = substr($_GET['inicial'], 0, 4);  
          $fecha_final_dia = substr($_GET['final'], 8, 2);
          $fecha_final_mes = substr($_GET['final'], 5, 2); 
          $fecha_final_anio = substr($_GET['final'], 0, 4);
          echo ' <div class="col-sm-5">
                   <h2><p><a>Buscar del '.$fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio.'</a></p></h2>
                   <div class="col-sm-5"></div>
                   <div class="col-sm-2"><button class="btn btn-success btn-lg btn-block" onclick="regresar_logs()"><span class="glyphicon glyphicon-edit"></span> Regresar</button></div>
                   </div>';
  echo ' </div>';
          //$logs->mostrar_logs($_GET['inicial'],$_GET['final'],1);
  echo ' </div>';
  //comentario
?>
