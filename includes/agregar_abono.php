<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  include_once("clase_hab.php");
  $forma_pago= NEW Forma_pago(0);
  $hab = NEW Hab($_GET['hab_id']);//$_GET['hab_estado'] es mov
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" onclick="reiniciarintervalo()">&times;</button>
      <h3 class="modal-title">AHCloud>Panel>Habitacion '.$hab->nombre.'</h3>
      <h2>-Abonar</h2>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Descripcion:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input class="form-control" type="text" id="descripcion" placeholder="Ingresa la descripcion del abono" maxlength="90">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Forma de pago:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <select class="form-control" id="forma_pago">
            <option value="0">Selecciona</option>';
            $forma_pago->mostrar_forma_pago();
            echo '
          </select>
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Cargo faltante:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input class="form-control" type="text" id="cargo" placeholder="$'.number_format($_GET['faltante'], 2).'" maxlength="20" disabled>
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Abono:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input class="form-control" type="number" id="abono" placeholder="Ingresa la cantidad del abono">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="guardar_abono('.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['faltante'].')"><span class="glyphicon glyphicon-edit"></span> Aceptar</button>
    </div>
  </div>';
?>
