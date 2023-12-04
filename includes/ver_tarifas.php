<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  
  echo ' <div class="main_container">
        <header class="main_container_title">
                <h2>TARIFAS HOSPEDAJE</h2>
        </header>';
          $tarifa->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
