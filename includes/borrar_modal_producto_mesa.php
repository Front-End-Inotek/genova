<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario = NEW Inventario(0);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Borrar Producto
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">';
        $producto = $inventario->obtengo_nombre($_GET['id_producto']);
        echo '¿Aceptas quitar '.$producto.'?';
        echo '</div>
      </div><br><br>
      <h5>Introduzca los datos de autorización:</h5></br>
      <div class="row">
        <div class="col-sm-2" >Usuario:</div>
        <div class="col-sm-10" >
        <div class="form-group">
          <input class="form-control" type="text"  id="usuario" placeholder="Usuario">
        </div>
        </div>
      </div><br>
      <div class="row">
        <div class="col-sm-2" >Contraseña:</div>
        <div class="col-sm-10" >
        <div class="form-group">
          <input class="form-control" type="password"  id="contrasena" placeholder="Contraseña">
        </div>
        </div>
      </div>
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger btn" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success btn" onclick="eliminar_producto_mesa('.$_GET['mesa_id'].','.$_GET['producto'].','.$_GET['id_producto'].')"> Aceptar</button>
    </div>
  </div>';
?>