<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta_maestra.php");
  $cm= NEW CuentaMaestra(0);
  
  echo ' <div class="main_container">
                <header class="main_container_title">
                        <h2>CUENTAS MAESTRAS</h2>';
          $cm->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>

