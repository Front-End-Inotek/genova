<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CATEGORIAS</h2></div>';
          $categoria->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
