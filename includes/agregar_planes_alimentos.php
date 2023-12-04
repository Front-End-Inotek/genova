<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
  <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar plan de alimentos </h5>
          <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
           </svg>
        </button>
        </div>

        <div class="modal-body">

        <div class="inputs_form_container">
               <div class="form-floating input_container">
               <input type="text" id="nombre" name ="nombre" class="form-control custom_input" placeholder="Nombre" >
               <label for="nombre" > Nombre </label>
          </div>
        </div>

        <div class="inputs_form_container">
        <div class="form-floating input_container">
        <input type="text" maxlength="10"  onkeypress="validarNumero(event)" id="codigo" name ="codigo" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" placeholder="codigo" >
                <label for="codigo" id="inputGroup-sizing-default"> Costo Adulto</labelclass=>
            </div>
        </div>

        <div class="inputs_form_container">
        <div class="form-floating input_container">
            <input type="text" maxlength="10"  onkeypress="validarNumero(event)" id="costo_menores" name ="costo_menores" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" placeholder="costo menores" >
                <label for="costo_menores" id="inputGroup-sizing-default"> Costo Menores </label>
            </div>
        </div>

        <div class="inputs_form_container">
        <div class="form-floating input_container">
        <input id="descripcion" name="descripcion" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" placeholder="Descripción" ></input>
        <label for="descripcion" id="inputGroup-sizing-default"> Descripción </label>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <button type="submit" class="btn btn-primary btn-block" value="Guardar" onclick="guardar_planes_alimentos()">Guardar</button>
        </div>
        </div>
      </div>';
?>
