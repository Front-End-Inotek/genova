<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  $logs = NEW Log(0);

  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">LOGS</h2></div>
          
          <div class="row">';
          $fecha_inicial_dia = substr($_GET['inicial'], 8, 2);
          $fecha_inicial_mes = substr($_GET['inicial'], 5, 2); 
          $fecha_inicial_anio = substr($_GET['inicial'], 0, 4);  
          $fecha_final_dia = substr($_GET['final'], 8, 2);
          $fecha_final_mes = substr($_GET['final'], 5, 2); 
          $fecha_final_anio = substr($_GET['final'], 0, 4);
          echo ' <div class="col-sm-8">
                   <h2><p>Buscar del '.$fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio.'</p></h2>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-2"><button class="btn btn-info btn-block" onclick="regresar_logs()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
          </div>';
  echo '

         <div class="row">
                <div class="col-sm-12">'.$logs->mostrar_logs($_GET['inicial'],$_GET['final'],1).'</div>
         </div>';
  echo ' </div>';
  //comentario
?>
