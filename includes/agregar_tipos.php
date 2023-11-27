<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar tipo de habitación </h5>
          <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
            </svg>
          </button>
        </div>

        <div class="modal-body">

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input type="text" id="nombre" name ="nombre" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" placeholder="Nombre"  >
            <label for="nombre">Nombre</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input type="text" id="codigo" name ="codigo" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default"  placeholder="Codigo" >
            <label for="codigo">Codigo</label>
          </div>
        </div>
        <div class="input-group mb-3 d-flex gap-2">
          <label for="color" class="form-label">Color de la hab.</label>
          <input type="color" class="form-control form-control-color" id="colorHab" value="#2C8FEB" title="Color">
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <button type="submit" class="btn btn-primary btn-block" value="Guardar" onclick="guardar_tipo()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
              <path d="M11 2H9v3h2z"/>
              <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
            </svg>
            Guardar
          </button>
        </div>
        </div>
      ';
?>
