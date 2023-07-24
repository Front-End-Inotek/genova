<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
  <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar tipo de abono</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            &times;
          </button>
        </div>
        <div class="modal-body">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span maxlength="20" class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Nombre </span>
            </div>
              <input type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label for="descripcion" class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Descripción </label>
        </div>
          <textarea maxlength="255" rows="4" type="text" id="descripcion" name ="descripcion" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" ></textarea>
    </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_tipos_abonos()">
        </div>
        </div>
      </div>';
?>
