<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago($_GET['id']);
  $c="";
  if($forma_pago->garantia){
    $c="checked";
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Editar Forma de Pago
      <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
         <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z">&times;</button>
    </div>
    <div class="modal-body">
    <div class="inputs_form_container">
               <div class="form-floating input_container">
          <input class="form-control custom_input" type="text" id="descripcion_nueva" value="'.$forma_pago->descripcion.'" maxlength="50" placeholder="Descripción">
          <label for="nombre" id="inputGroup-sizing-default"> Descripción </label>
          </div>
        </div>
      <div class="row">
      <div class="col-sm-2">Garantía:</div>
      <div class="col-sm-9">
      <div class="form-group">
        <input class="form-check-input" type="checkbox" id="garantia_nueva" value="'.$forma_pago->garantia.'"  '.$c.'>
      </div>
      
      </div>
      <div class="col-sm-1"></div>
    </div>
    </div>
    
    <div class="modal-footer" id="boton_forma">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="modificar_forma_pago('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>
