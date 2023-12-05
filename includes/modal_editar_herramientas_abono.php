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
      <h3 class="modal-title">Editar abono</h3>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">
        <div class="form-floating mb-3">
          <input class="form-control custom_input" placeholder="abono"  type="text" id="abono" value="'.$_GET['abono'].'">
          <label for="abono">Abono</label>
        </div>
    <div>

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="modificar_herramientas_abono('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].','.$_GET['id_maestra'].')"> Aceptar</button>
    </div>
  </div>';
?>
