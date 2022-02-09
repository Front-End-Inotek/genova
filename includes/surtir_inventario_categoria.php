<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_surtir.php");
  $inventario = NEW Inventario(0);
  $surtir = NEW Surtir(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">SURTIR INVENTARIO</h2></div>';
          $inventario->mostrar_surtir_categoria($_GET['categoria']);
         echo  '</div>';
?>
