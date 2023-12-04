<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  $tipo= NEW Tipo(0);
  
  echo ' <div class="main_container">
        <header class="main_container_title">
                <h2>TIPOS DE HABITACIONES</h2>
        </header>';
          $tipo->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
