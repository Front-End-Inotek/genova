<?php
  date_default_timezone_set('America/Mexico_City');
  $id_maestra=0;
  if(isset($_GET['id_maestra'])){
    $id_maestra=$_GET['id_maestra'];
  }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Editar Pedido
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
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger btn" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success btn" onclick="modificar_producto_restaurante('.$_GET['producto'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].','.$_GET['mesa'].','.$_GET['cantidad'].','.$id_maestra.')"> Aceptar</button>
    </div>
  </div>';
?>
