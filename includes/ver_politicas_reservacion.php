<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_politicas_reservacion.php");
  $pr= new PoliticasReservacion(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">POLÍTICAS DE RESERVACIÓN</h2></div>';
          $pr->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
