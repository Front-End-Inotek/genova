<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario = NEW Inventario(0);
  echo ' <div class="container-fluid blanco">

          <div class="row">
           <h2>Surtir Inventario</h2>
           <div class="col-sm-8">';
            $inventario->mostrar_surtir_inventario();
           echo  '</div>
           <div class="col-sm-4 " id="a_surtir">';
            $inventario->mostrar_a_surtir();
           echo  '</div>
          </div>';
?>
