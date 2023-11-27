<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab(0);
  echo '
        <div class="modal-header">
          <h5 class="modal-title" id="modal_editar_tarifas">Agregra tipo de habitación</h5>
          <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
           </svg>
        </button>
        </div>

        <div class="modal-body">

            <div class="inputw_form_container">
              <div class="form-floating input_container">
                 <input type="text" id="inputGroup-sizing-default" name ="numero" value="" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" placeholder="Numero" >
                  <label for="numero" > Número </label>
              </div>
              
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 200px; font-size: 16px;">Tipo de habitación</label>
                </div>
            <select class="form-control" id="tipo" name = "tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $hab->mostrar_hab();
              echo '
            </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Leyenda de habitación </span>
                </div>
                  <input type="text" id="comentario" name ="comentario" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_hab()">Guardar<button>
            </div>
            </div>
          </div>';
?>