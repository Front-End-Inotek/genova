<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  $tipo= NEW Tipo(0);
  
  echo ' <div class="container">
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">TIPOS DE HABITACIONES</h2></div>';
          $tipo->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
