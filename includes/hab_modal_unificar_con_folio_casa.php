<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= $_GET['hab_id'];
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <p class="modal-title">
        Unificar habitacion '.$hab.' con folio casa
      </p>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>
    <div class="modal-body">

      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input type="text" class="form-control custom_input" id="folio_casa" placeholder="Ingresar folio casa" maxlength="50">
          <label for="folio_casa">Folio casa</label>
        </div>
      </div>


    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="aceptar_unificacion('.$_GET['hab_id'].')"> Aceptar</button>
    </div>
  </div>';
?>