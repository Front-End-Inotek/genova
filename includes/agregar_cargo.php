<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  include_once("clase_hab.php");
  $forma_pago= NEW Forma_pago(0);
  $hab = NEW Hab($_GET['hab_id']);//$_GET['hab_estado'] es mov
  $mov=0;
  $id_maestra=0;
  if(isset($_GET['mov'])){
    if($_GET['mov']!=0){
      $mov = $_GET['mov'];
    }
  }
  if(isset($_GET['id_maestra'])){
    if($_GET['id_maestra']!=0){
      $id_maestra = $_GET['id_maestra'];
    }
  }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">';
      if($id_maestra==0){
        echo '<h3 class="modal-title">AHCloud>Panel>Habitacion '.$hab->nombre.'</h3>';
      }else{
        require_once('clase_cuenta_maestra.php');
        $cm = new CuentaMaestra($id_maestra);
        echo '<h3 class="modal-title">AHCloud>Panel>Cuenta Maestra '.$cm->nombre.'</h3>';
      }
    echo '
      <h2>Cobrar</h2>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>
    <div class="modal-body">
      <div class="row flex-wrap">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Descripcion:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input class="form-control" type="text" id="descripcion" placeholder="Ingresa la descripcion del abono" maxlength="20">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Cargo actual:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input class="form-control" type="text" id="cargo_actual" placeholder="$'.number_format($_GET['faltante'], 2).'" maxlength="20" disabled>
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Cargo:</div>
        <div class="col-sm-7">
        <div class="form-group">
          <input maxlength="10" class="form-control" type="text" id="cargo" placeholder="Ingresa la cantidad del cargo" onkeypress="validarNumero(event)">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
    <div>
    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="guardar_cargo('.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['faltante'].','.$mov.','.$id_maestra.')"> Aceptar</button>
    </div>
  </div>';
?>
