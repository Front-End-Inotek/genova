<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
  <!-- Modal -->

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregra tipo de habitacion </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 12px;"> Nombre </span>
            </div>
              <input type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="font-size: 12px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 12px;"> Codigo </span>
            </div>
              <input type="text" id="codigo" name ="codigo" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" style="font-size: 12px;" >
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_tipo()">
        </div>
        </div>
      </div>';
?>
