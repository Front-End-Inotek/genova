<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  $configuracion= NEW Configuracion(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">TIPOS DE ABONOS</h2></div>';
          $configuracion->mostrar_tipos_abonos($_GET['usuario_id']);
  echo '
         </div>';
?>
