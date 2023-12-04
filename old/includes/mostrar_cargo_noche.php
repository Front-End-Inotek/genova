<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab = NEW Hab(0);
  
  echo ' <div class="container blanco">';
          $total_final= $hab->mostrar_cargo_noche();
          echo '<div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">Total $ '.number_format($total_final, 2).'</div>';
          echo '</div>';
  echo '
         </div>';
?>