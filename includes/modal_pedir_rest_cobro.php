<?php
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago(0);
  $total= $_GET['total'];
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Pago del Restaurante</h3>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">
      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input class="form-control custom_input" aria-label="Default" autocomplete="off" type="number" id="efectivo" aria-describedby="inputGroup-sizing-default" placeholder="Hola" onKeyUp="cambio_rest_cobro('.$total.')">
          <label for="efectivo" >Efectivo</label>
        </div>

        <div class="form-floating input_container">
          <input class="form-control custom_input" aria-label="Default" autocomplete="off" type="number" id="cambio" aria-describedby="inputGroup-sizing-default" placeholder="Hola" value="0" disabled>
          <label for="cambio" >Cambio</label>
        </div>
      </div>

      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input class="form-control custom_input" aria-label="Default" autocomplete="off" type="number" id="monto" aria-describedby="inputGroup-sizing-default" placeholder="Hola">
          <label for="monto" >Monto</label>
        </div>

        <div class="form-floating input_container">
          <select class="form-select custom_input" id="forma_pago" aria-label="Floating label select">
            <option selected value="0" disabled>Selecciona</option>';
            $forma_pago->mostrar_forma_pago_restaurante();
            echo '
          </select>
          <label for="cambio" >Forma de pago</label>
        </div>
      </div>

      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input class="form-control custom_input" aria-label="Default" autocomplete="off" type="text" id="folio" aria-describedby="inputGroup-sizing-default" placeholder="Hola" maxlength="40">
          <label for="folio" >Folio autorización tarjeta</label>
        </div>

        <div class="form-floating input_container">
          <input class="form-control custom_input" aria-label="Default" autocomplete="off" type="number" id="descuento" aria-describedby="inputGroup-sizing-default" placeholder="Hola" onKeyUp="cambio_rest_descuento('.$total.')">
          <label for="descuento" >Descuento</label>
        </div>
      </div>

      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <input class="form-control custom_input" aria-label="Default" autocomplete="off" type="text" id="total" aria-describedby="inputGroup-sizing-default" placeholder="Hola" value="'.number_format($total, 2).'" disabled>
          <label for="total" >Total</label>
        </div>
      </div>

      <div class="inputs_form_container">
        <div class="form-floating input_container">
          <textarea class="form-control custom_input" placeholder="Comentario" id="comentario" maxlenght="200" style="height: 100px"></textarea>
          <label for="comentario">Comentarios</label>
        </div>
      </div>

    <div class="modal-footer" id="boton_pago">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="aplicar_rest_cobro('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].',0)"> Cobrar</button>
    </div>
  </div>';
?>