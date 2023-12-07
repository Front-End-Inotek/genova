<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $preasignada = 0;

  $correo = $_GET['correo'];
  $garantizada = $_GET['garantizada'];

  if(isset($_GET['preasignada']) && $_GET['preasignada']!=0){
    $preasignada=$_GET['preasignada'];
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Cancelar Reservación: '.$_GET['id']  ; echo '</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">

    <div class="inputs_form_container" >
      <div class="form-floating input_container">
        <input type="text" name="nombre_cancela" class="form-control custom_input" id="nombre_cancela" maxlength="60" placeholder="Numero de tarjeta">
        <label class="asterisco" for="nombre_cancela">Quién cancela</label>
      </div>
    </div>


    <div class="inputs_form_container" >
      <div class="form-floating input_container">
        <input type="text" name="nombre_cancela" class="form-control custom_input" id="motivo_cancela" maxlength="255" placeholder="Numero de tarjeta">
        <label class="asterisco" for="motivo_cancela">Motivo de cancelacíon</label>
      </div>
    </div>

    
    </div>
    
    <div class="modal-footer" id="boton_cancelar_reservacion">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="cancelar_reservacion('.$_GET['id'].','.$preasignada.',\''.$correo.'\','.$garantizada.')"> Aceptar</button>
    </div>
  </div>';
?>
