<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  $configuracion= NEW Configuracion(0);
  
  echo ' <div class="main_container"> 
          <div class="main_container_title">
                <h2>PLANES DE ALIMENTOS</h2>
        </div>';
          $configuracion->mostrar_planes_alimentos($_GET['usuario_id']);
  echo '
         </div>';
?>
