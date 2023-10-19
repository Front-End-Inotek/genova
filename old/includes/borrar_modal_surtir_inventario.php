<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_surtir.php");
  $inventario= NEW Inventario(0);
  $surtir = NEW Surtir($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Borrar Producto Surtir Inventario
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      $producto = $surtir->producto;
      $mostrar = $inventario->obtengo_nombre($producto);
      echo '¿Aceptar borrar el producto '.$mostrar.'?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="borrar_surtir_inventario('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>
