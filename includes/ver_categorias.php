<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria(0);
  
  echo ' <div class="main_container">
          <div class="main_container_title">
                <h2 >CATEGORIAS</h2>
        </div>';
          $categoria->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
