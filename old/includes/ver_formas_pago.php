<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">TIPOS DE FORMAS DE PAGO</h2></div>';
          $forma_pago->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
