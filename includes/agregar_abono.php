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
        <div class="col-sm-2">Descripcion:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="text" id="usuario" placeholder="Ingresa la descripcion del abono" maxlength="50">
        </div>
        </div>
        <div class="col-sm-2">Forma de pago:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <select class="form-control" id="forma_pago">
            <option value="0">Selecciona</option>';
            $forma_pago->mostrar_forma_pago();
            echo '
          </select>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2">Contraseña:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="password" id="recontrasena" placeholder="Ingresa nuevamente la contraseña del usuario" maxlength="50">
        </div>
        </div>
        <div class="col-sm-2">Puesto:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="text" id="puesto" placeholder="Ingresa el puesto del usuario" maxlength="20">
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2">Celular:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="text" id="celular" placeholder="Ingresa el celular del usuario" maxlength="20">
        </div>
        </div>
        <div class="col-sm-2">Correo:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="text" id="correo" placeholder="Ingresa el correo del usuario" maxlength="70">
        </div>
        </div>
      </div>
    <div>     

    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="borrar_tarifa('.$_GET['hab_id'].')"><span class="glyphicon glyphicon-edit"></span> Aceptar</button>
    </div>
  </div>';
?>
