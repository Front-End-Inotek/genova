<?php
  date_default_timezone_set('America/Mexico_City');

  $id= $_GET['id'];
  $nombre = $_GET['nombre'];
  $descripcion = $_GET['descripcion'];
      echo '
      <!-- Modal -->
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel2">Editar tipo de abono </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                &times;
              </button>
            </div>
            <div class="modal-body">
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Nombre </span>
                </div>
                  <input maxlength="20" type="text" id="nombre" name ="nombre" value="'.$nombre.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Descripción </span>
                </div>
                  <input type="text" id="descripcion" name ="descripcion" value="'.$descripcion.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_tipo_abono('.$id.')">Guardar</button>
            </div>
            </div>
          </div>';
?>
