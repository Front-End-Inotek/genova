<?php
  date_default_timezone_set('America/Mexico_City');

  $id = $_GET['id'];
  $mov = $_GET['mov'];
  echo '
  <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar cargo adicional</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;">Cargo</span>
            </div>
              <input type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Monto </span>
            </div>
              <input type="number" id="monto" name ="monto" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_cargo_adicional('.$id.','.$mov.')">
        </div>
        </div>
      </div>';
?>
