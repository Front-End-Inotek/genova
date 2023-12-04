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
      Editar Producto Surtir Inventario
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">';
        $producto = $surtir->producto;
        $mostrar = $inventario->obtengo_nombre($producto);
        echo '  '.$mostrar;
        echo '</div>
      </div><br>

      <div class="row">
        <div class="col-sm-3" >Cantidad:</div>
        <div class="col-sm-9" >
        <div class="form-group">
        <input class="form-control" type="number"  id="cantidad" value="'.$surtir->cantidad.'"/>
        </div>
        </div>
      </div><br>
    </div>
    <div class="modal-footer" id="boton_surtir">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="editar_surtir_inventario('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>
