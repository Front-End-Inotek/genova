<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Editar Producto
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-2" >Cantidad:</div>
        <div class="col-sm-10" >
        <div class="form-group">
          <input class="form-control" type="number"  id="cantidad" value="'.$_GET['cantidad'].'">
        </div>
        </div>
      </div><br>
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
      <button type="button" class="btn btn-success btn" onclick="modificar_producto_mesa('.$_GET['mesa_id'].','.$_GET['producto'].','.$_GET['precio'].','.$_GET['id_producto'].','.$_GET['cantidad'].')"> Aceptar</button>
    </div>
  </div>';
?>
