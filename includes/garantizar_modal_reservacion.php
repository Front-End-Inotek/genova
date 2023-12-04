<?php

date_default_timezone_set('America/Mexico_City');
include_once("clase_reservacion.php");
include_once("clase_forma_pago.php");
$reservacion= new Reservacion($_GET['id']);
$forma_pago = new Forma_pago(0);
$preasignada = 0;

$correo = $_GET['correo'];
$garantizada = $_GET['garantizada'];

$huesped_id =$_GET['huesped_id'];

if(isset($_GET['preasignada']) && $_GET['preasignada']!=0) {
    $preasignada=$_GET['preasignada'];
}
echo '
  <!-- Modal content-->
    <div class="modal-header">
      <h5>Garantizar Reservación: '.$_GET['id'].' <h5>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
        </svg>
      </button>
    </div><br>

    <div class="modal-body">

    <form id="garantia-tarjeta">

      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <select class="form-select custom_input" id="estado"  onchange="garantizar_reserva_selects(event)">
            <option selected disabled>Seleccione una opción</option>
            <option value="garantizada">Garantizada</option>
            <option value="pendiente">Sin garantía</option>
          </select>
          <label for="estado">Estado</label>
        </div>
      </div>

      <div class="inputs_form_container input_container">
        <div class="form-floating input_container">
          <select class="form-control custom_input" id="forma-garantia" required onchange="garantizar_reserva_selects(event)" >
          <option selected disabled>Seleccione una opción</option>';
          $forma_pago->mostrar_forma_pago();
    echo'
          </select>
          <label for="forma-garantia">Metodo de garantia</label>
        </div>
      </div>

      <div id="div-tarjeta" style="display:none">
        <div class="row">
        <div class="col-sm-3 asterisco" >Número de tarjeta:</div>
        <div class="col-sm-9" >
        <div class="form-group">
        <input onchange="" type="number" name="numero de tarjeta" class="form-control" id="numero_tarjeta" maxlength="20" value="" required/>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 asterisco" >Nombre en tarjeta:</div>
        <div class="col-sm-9" >
        <div class="form-group">
        <input type="text" class="form-control" name="nombre en tarjeta" id="cardholder" maxlength="25" autocorrect="off" spellcheck="false" value="" required/>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3" >Tipo de tarjeta:</div>
        <div class="col-sm-9" >
        <div class="form-group">
        <input  placeholder="Mastercard, Visa, American Express, etc..." type="text" class="form-control" id="tipo" maxlength="20" value="" />
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 asterisco" >Expira:</div>
        <div class="col-sm-9" >
        <div class="input-group expire-date">
          <div class="input-group-prepend">
          </div>
          <input required name="Mes expiracion" type="tel" class="form-control" id="expires-month" placeholder="MM" allowed-pattern="[0-9]" maxlength="2">
          <div class="input-group-prepend divider">
          </div>
          <input name="Año expiracion" required type="tel" class="form-control" id="expires-year" placeholder="YY" allowed-pattern="[0-9]" maxlength="2">
          <div class="input-group-append">
          </div>
          </div>
        </div>
      </div>
      </div>

      <div class="inputs_form_container">
        <div class="form-floating input_container" >
          <input class="form-control custom_input" type="text"  id="monto" placeholder="Ingresa el monto con el que garantizas la reservación" maxlength="60">
          <label for="monto">Monto</label>
        </div>
      </div>
  
    </div>
    </form>
    <div class="modal-footer" id="boton_cancelar_reservacion">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="garantizar_reservacion('.$_GET['id'].','.$preasignada.',\''.$correo.'\','.$garantizada.','.$huesped_id.')"> Aceptar</button>
    </div>
  ';
