<?php
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Pedir Restaurante
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-2">Comentario:</div>
        <div class="col-sm-10">
        <div class="form-group">
          <input class="form-control" type="text" id="comentario" placeholder="Comentario del pedido" maxlength="200">
        </div>
        </div>
      </div>
      <br>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="aplicar_rest_cobro_mesa('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].')"> Pedir</button>
    </div>
  </div>';
?>