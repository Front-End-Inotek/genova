<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion = NEW Reservacion($_GET['id']);
  include_once("clase_cuenta.php");
  $cuenta= NEW Cuenta($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Editar cargo
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Cargo:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input class="form-control" type="text" id="cargo" value="'.$_GET['cargo'].'">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="modificar_herramientas_cargo('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].')"><span class="glyphicon glyphicon-edit"></span> Aceptar</button>
    </div>
  </div>';
?>
