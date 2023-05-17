<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta_maestra.php");
  $cm= NEW CuentaMaestra(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CUENTAS MAESTRAS</h2></div>';
          $cm->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
