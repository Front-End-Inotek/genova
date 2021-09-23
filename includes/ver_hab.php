<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  
  echo ' <div class="container">
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">TARIFAS HOSPEDAJE</h2></div>';
          $tarifa->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
