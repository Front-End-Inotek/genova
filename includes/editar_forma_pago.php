<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Editar Forma de Pago
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-2">Descripción:</div>
        <div class="col-sm-9">
        <div class="form-group">
          <input class="form-control" type="text" id="descripcion_nueva" value="'.$forma_pago->descripcion.'" maxlength="50">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
    </div>
    
    <div class="modal-footer" id="boton_forma">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="modificar_forma_pago('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>
