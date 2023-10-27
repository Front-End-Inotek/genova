<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
  <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar plan de alimentos </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            &times;
          </button>
        </div>
        <div class="modal-body">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Nombre </span>
            </div>
              <input type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="font-size: 16px;"> Costo Adulto</span>
            </div>
              <input
              type="text" maxlength="10"  onkeypress="validarNumero(event)"
              id="codigo" name ="codigo" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="font-size: 16px;"> Costo Menores</span>
            </div>
              <input
              type="text" maxlength="10"  onkeypress="validarNumero(event)"
              id="costo_menores" name ="costo_menores" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

      <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Descripción </span>
          <textarea id="descripcion" name="descripcion" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;"></textarea>
      </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_planes_alimentos()">Guardar</button>
        </div>
        </div>
      </div>';
?>