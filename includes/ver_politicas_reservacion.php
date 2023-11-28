<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_politicas_reservacion.php");
  $pr= new PoliticasReservacion(0);
  
  echo ' <div class="main_container">
          <div class="main_container_title">
                <h2>POLÍTICAS DE RESERVACIÓN</h2>
        </div>';
          $pr->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
