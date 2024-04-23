<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_surtir.php");
  $inventario= NEW Inventario(0);
  $surtir = NEW Surtir($_GET['id']);
  echo '
    <div class="modal-header">
      <h5>Editar Producto Surtir Inventario</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">

      <div class="row">
        <div class="col-sm-12">';
        $producto = $surtir->producto;
        $mostrar = $inventario->obtengo_nombre($producto);
        echo '  '.$mostrar;
        echo '</div>
      </div><br>

        <div class="form-floating input_container">
          <input class="form-control custom_input" type="number"  id="cantidad" value="'.$surtir->cantidad.'" placeholder="Cantidad" />
          <label class="cantidad" >Cantidad</label>
        </div>
    </div>

    <div class="modal-footer" id="boton_surtir">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="editar_surtir_inventario('.$_GET['id'].')"> Aceptar</button>
    </div>
  ';
?>