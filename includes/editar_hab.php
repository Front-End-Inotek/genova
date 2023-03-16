<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['id']);
  echo '
 <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar tipo de habitacion </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Nombre </span>
                </div>
                  <input type="text" id="nombre" name ="nombre" value="'.$hab->nombre.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 200px; font-size: 16px;">Tipo de habitación</label>
                </div>
            <select class="form-control" id="tipo" name = "tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $hab->mostrar_hab_editar($hab->tipo);
              echo '
            </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Leyenda de habitación </span>
                </div>
                  <input type="text" id="comentario" name ="comentario" value="'.$hab->comentario.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_hab('.$_GET['id'].')">
            </div>
            </div>
          </div>';
?>