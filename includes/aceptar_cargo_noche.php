<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $hab = NEW Hab(0);
  $logs = NEW Log(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CARGO POR NOCHE</h2></div>';
          $total_final= $hab->mostrar_cargo_noche($_GET['usuario_id']);
          echo '<div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">Total $ '.number_format($total_final, 2).'</div>';
          echo '</div>';
  echo '
         </div>';
?>