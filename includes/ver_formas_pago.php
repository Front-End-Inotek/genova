<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  
  echo ' <div class="main_container">
          <div class="main_container_title">
                <h2>TIPOS DE FORMAS DE PAGO</h2>
        </div>';
          $forma_pago->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
