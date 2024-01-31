<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  include_once("clase_hab.php");

  include_once('clase_configuracion.php');

  $config = new Configuracion();
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
        echo '<h3 class="modal-title">Abonar a habitación '.$hab->nombre.'</h3>';
      }else{
        require_once('clase_cuenta_maestra.php');
        $cm = new CuentaMaestra($id_maestra);
        echo '<h3 class="modal-title">Abonar a cuenta Maestra '.$cm->nombre.'</h3>';
      }
    echo '
        <button type="button" class="btn btn-light" data-dismiss="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
          </svg>
        </button>
    </div>
    <div class="modal-body">
      <div class="form-garantia">
        <div class="inputs_form_container">
        <div class="form-floating input_container">
          <select name="select" class="form-select custom_input" id="leer_tipo_abono" aria-label="Floating label select example">
            <option value="value1" selected disabled>Selecciona una opción</option>
            <option value="value2">Abono restaurante</option>
            <option value="value3">Abono hospedaje</option>
          </select>
          <label for="leer_tipo_abono">Descripción</label>
        </div>
        </div>

        <div class="inputs_form_container">
        <div class="form-floating input_container">
          <select class="form-select custom_input" id="forma_pago" aria-label="Floating label select example">
            <option value="0" selected disabled>Selecciona una opción</option>';
            $forma_pago->mostrar_forma_pago();
            echo '
          </select>
          <label for="forma_pago">Forma de pago</label>
        </div>
        </div>

        <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input type="email" class="form-control custom_input" id="cargo" placeholder="Cargo faltante" value="$'.number_format($_GET['faltante'], 2).'" maxlength="20" disabled>
          <label for="cargo">Cargo faltante</label>
        </div>
        </div>

        <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input type="email" class="form-control custom_input" id="abono" placeholder="Ingresa la cantidad del abono" maxlength="10" onkeypress="validarNumero(event)">
          <label for="abono">Abono</label>
        </div>
        </div>
        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input type="text" class="form-control custom_input" id="observaciones" placeholder="Ingresa comentario" maxlength="100"">
            <label for="Observaciones">Observaciones</label>
          </div>
        </div>
      </div>
    <div>

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="guardar_abono('.$_GET['hab_id'].','.$_GET['estado'].', \''.$_GET['faltante'].'\','.$mov.','.$id_maestra.')"> Aceptar</button>
    </div>
  </div>';
?>
