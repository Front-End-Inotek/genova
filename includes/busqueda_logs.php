<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  $logs = NEW Log(0);

  echo ' <div class="main_container"> 
              <header class="main_container_title">
                     <h2>LOGS</h2>
                     <button class="btn btn-link" onclick="regresar_logs()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                                   <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"></path>
                            </svg>
                     </button>
              </header>
          
          ';
          $fecha_inicial_dia = substr($_GET['inicial'], 8, 2);
          $fecha_inicial_mes = substr($_GET['inicial'], 5, 2); 
          $fecha_inicial_anio = substr($_GET['inicial'], 0, 4);  
          $fecha_final_dia = substr($_GET['final'], 8, 2);
          $fecha_final_mes = substr($_GET['final'], 5, 2); 
          $fecha_final_anio = substr($_GET['final'], 0, 4);
          echo '
              <h4>Buscar del '.$fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio.'</h4>
          ';
  echo '
       '.$logs->mostrar_logs($_GET['inicial'],$_GET['final'],1).'
         ';
  echo ' </div>';
  //comentario
?>
