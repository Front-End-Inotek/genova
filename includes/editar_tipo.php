<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  $tipo= NEW Tipo($_GET['id']);
      echo '
      <!-- Modal -->
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel2">Editar tipo de habitacion </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                &times;
              </button>
            </div>
            <div class="modal-body">
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Nombre </span>
                </div>
                  <input type="text" id="nombre" name ="nombre" value="'.$tipo->nombre.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 105px; font-size: 16px;"> Codigo </span>
                </div>
                  <input type="text" id="codigo" name ="codigo" value="'.$tipo->codigo.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_tipo('.$_GET['id'].')">
            </div>
            </div>
          </div>';
?>
