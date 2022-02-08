<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cargo_noche.php");
  $cargo_noche= NEW Cargo_noche(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CARGOS POR NOCHE</h2></div>';
          $cargo_noche->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
