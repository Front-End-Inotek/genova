<?php
  date_default_timezone_set('America/Mexico_City');

  $id = $_GET['id'];
  $mov = $_GET['mov'];
  echo '
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar cargo adicional</h5>
          <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
          </button>
        </div>

        <div class="modal-body">
        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input type="text" class="form-control custom_input" required id="nombre" name="nombre" autocomplete="off" placeholder="Nombre" />
            <label for="nombre" class="asterisco">Descrpcion</label>
          </div>
        </div>
        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input type="text" class="form-control custom_input" required id="monto" name="monto" autocomplete="off" placeholder="Nombre" />
            <label for="monto" class="asterisco">Cargo</label>
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <button type="submit" class="btn btn-primary" value="Guardar" onclick="guardar_cargo_adicional('.$id.','.$mov.')">Guardar</button>
        </div>
        </div>
      ';
?>
